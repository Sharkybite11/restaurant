import RPi.GPIO as GPIO
import time
import threading
import requests
import json
import sys

# Set default encoding to UTF-8
if sys.stdout.encoding != 'utf-8':
    sys.stdout.reconfigure(encoding='utf-8')

# GPIO pin numbers (BCM mode)
COIN_PIN = 17  # GPIO17 = Pin 11
BILL_PIN = 27  # GPIO27 = Pin 13

coin_pulse_count = 0
bill_pulse_count = 0
total_inserted = 0.0
lock = threading.Lock()

# Coin acceptor pulse handler
def coin_callback(channel):
    global coin_pulse_count
    with lock:
        coin_pulse_count += 1
        print(f"Coin pulse detected! Total pulses: {coin_pulse_count}")

# Bill acceptor pulse handler
def bill_callback(channel):
    global bill_pulse_count
    with lock:
        bill_pulse_count += 1
        print(f"Bill pulse detected! Total pulses: {bill_pulse_count}")

def get_coin_value(pulses):
    # Philippine Peso coin values
    return {
        1: 1.0,    # P1
        2: 5.0,    # P5
        3: 10.0,   # P10
        4: 20.0    # P20
    }.get(pulses, 0.0)

def get_bill_value(pulses):
    # Philippine Peso bill values
    return {
        1: 20.0,   # P20
        2: 50.0,   # P50
        3: 100.0,  # P100
        4: 200.0,  # P200
        5: 500.0,  # P500
        6: 1000.0  # P1000
    }.get(pulses, 0.0)

def send_to_backend(amount):
    try:
        print(f"Attempting to send P{amount:.2f} to backend...")
        response = requests.post(
            "http://localhost/money/update",
            data={"inserted_amount": amount},
            headers={"Content-Type": "application/x-www-form-urlencoded"}
        )
        if response.status_code == 200:
            print(f"Successfully sent P{amount:.2f} to backend")
        else:
            print(f"Error sending to backend: {response.status_code}")
    except Exception as e:
        print(f"Error sending to backend: {str(e)}")

def monitor():
    global coin_pulse_count, bill_pulse_count, total_inserted
    print("Starting money monitoring...")
    while True:
        with lock:
            if coin_pulse_count > 0:
                value = get_coin_value(coin_pulse_count)
                total_inserted += value
                print(f"Coin inserted: P{value:.2f} | Total: P{total_inserted:.2f}")
                send_to_backend(total_inserted)
                coin_pulse_count = 0

            if bill_pulse_count > 0:
                value = get_bill_value(bill_pulse_count)
                total_inserted += value
                print(f"Bill inserted: P{value:.2f} | Total: P{total_inserted:.2f}")
                send_to_backend(total_inserted)
                bill_pulse_count = 0

        time.sleep(0.2)

if __name__ == "__main__":
    try:
        print("Initializing GPIO...")
        GPIO.setmode(GPIO.BCM)
        GPIO.setup(COIN_PIN, GPIO.IN, pull_up_down=GPIO.PUD_UP)
        GPIO.setup(BILL_PIN, GPIO.IN, pull_up_down=GPIO.PUD_UP)

        print("Setting up event detection...")
        GPIO.add_event_detect(COIN_PIN, GPIO.FALLING, callback=coin_callback, bouncetime=50)
        GPIO.add_event_detect(BILL_PIN, GPIO.FALLING, callback=bill_callback, bouncetime=50)

        print("Listening for coins and bills...")
        monitor()
    except KeyboardInterrupt:
        print("Stopping money listener...")
        GPIO.cleanup()
        print("Stopped.")
    except Exception as e:
        print(f"Unexpected error: {str(e)}")
        GPIO.cleanup() 