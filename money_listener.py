import RPi.GPIO as GPIO
import time
import threading
import requests
import json

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

# Bill acceptor pulse handler
def bill_callback(channel):
    global bill_pulse_count
    with lock:
        bill_pulse_count += 1

def get_coin_value(pulses):
    # Philippine Peso coin values
    return {
        1: 1.0,    # ₱1
        2: 5.0,    # ₱5
        3: 10.0,   # ₱10
        4: 20.0    # ₱20
    }.get(pulses, 0.0)

def get_bill_value(pulses):
    # Philippine Peso bill values
    return {
        1: 20.0,   # ₱20
        2: 50.0,   # ₱50
        3: 100.0,  # ₱100
        4: 200.0,  # ₱200
        5: 500.0,  # ₱500
        6: 1000.0  # ₱1000
    }.get(pulses, 0.0)

def send_to_backend(amount):
    try:
        response = requests.post(
            "http://localhost/money/update",
            data={"inserted_amount": amount},
            headers={"Content-Type": "application/x-www-form-urlencoded"}
        )
        if response.status_code == 200:
            print(f"Successfully sent ₱{amount:.2f} to backend")
        else:
            print(f"Error sending to backend: {response.status_code}")
    except Exception as e:
        print(f"Error sending to backend: {str(e)}")

def monitor():
    global coin_pulse_count, bill_pulse_count, total_inserted
    while True:
        with lock:
            if coin_pulse_count > 0:
                value = get_coin_value(coin_pulse_count)
                total_inserted += value
                print(f"Coin inserted: ₱{value:.2f} | Total: ₱{total_inserted:.2f}")
                send_to_backend(total_inserted)
                coin_pulse_count = 0

            if bill_pulse_count > 0:
                value = get_bill_value(bill_pulse_count)
                total_inserted += value
                print(f"Bill inserted: ₱{value:.2f} | Total: ₱{total_inserted:.2f}")
                send_to_backend(total_inserted)
                bill_pulse_count = 0

        time.sleep(0.2)

if __name__ == "__main__":
    GPIO.setmode(GPIO.BCM)
    GPIO.setup(COIN_PIN, GPIO.IN, pull_up_down=GPIO.PUD_UP)
    GPIO.setup(BILL_PIN, GPIO.IN, pull_up_down=GPIO.PUD_UP)

    GPIO.add_event_detect(COIN_PIN, GPIO.FALLING, callback=coin_callback, bouncetime=50)
    GPIO.add_event_detect(BILL_PIN, GPIO.FALLING, callback=bill_callback, bouncetime=50)

    print("Listening for coins and bills...")

    try:
        monitor()
    except KeyboardInterrupt:
        GPIO.cleanup()
        print("Stopped.") 