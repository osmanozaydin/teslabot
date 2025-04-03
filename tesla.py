import requests
import time

TELEGRAM_BOT_TOKEN = "7868225655:AAE0frJ9Af3tlPLPNDNMeWDLRLN6FM56UuA"
TELEGRAM_CHAT_ID = "1098391950"

TESLA_API_URL = "https://www.tesla.com/inventory/api/v1/inventory-results?&query=%7B%22options%22%3A%7B%22model%22%3A%22my%22%2C%22condition%22%3A%22new%22%2C%22arrangeby%22%3A%22Price%22%2C%22order%22%3A%22asc%22%2C%22market%22%3A%22TR%22%2C%22language%22%3A%22tr%22%7D%7D"

def send_telegram_message(message):
    url = f"https://api.telegram.org/bot{TELEGRAM_BOT_TOKEN}/sendMessage"
    data = {"chat_id": TELEGRAM_CHAT_ID, "text": message}
    requests.post(url, data=data)

def check_tesla_inventory():
    try:
        response = requests.get(TESLA_API_URL)
        response.raise_for_status()
        data = response.json()
        vehicles = data.get("results", {}).get("vehicles", [])

        for car in vehicles:
            price = car.get("Price", 0)
            if 1800000 <= price <= 2100000:
                trim = car.get("TrimName", "Model Y")
                vin = car.get("VIN", "")
                url = f"https://www.tesla.com/tr_tr/my/order/{vin}"
                send_telegram_message(f"Uygun Tesla bulundu!\\nModel: {trim}\\nFiyat: {price:,} ₺\\nLink: {url}")
                break
    except Exception as e:
        print("Hata:", e)

while True:
    check_tesla_inventory()
    time.sleep(1800)  # 30 dakikada bir çalışır
