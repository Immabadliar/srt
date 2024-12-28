import requests
from bs4 import BeautifulSoup
import time

def scrape_urls(page_content):
    soup = BeautifulSoup(page_content, "html.parser")
    links = soup.select(".s-title-instructions-style .a-link-normal")
    if not links:
        print("No product links found. The CSS selector might be incorrect.")
    return [f"https://www.amazon.com{link['href']}" for link in links if 'href' in link.attrs]

def fetch_page(url, max_retries=3):
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36",
        "Accept-Language": "en-US,en;q=0.9",
        "Accept-Encoding": "gzip, deflate, br",
        "Connection": "keep-alive",
        "Upgrade-Insecure-Requests": "1",
    }
    retries = 0
    while retries < max_retries:
        response = requests.get(url, headers=headers)
        if response.status_code == 200:
            return response
        elif response.status_code == 503:
            print("Received 503 error. Retrying...")
            time.sleep(5)  # Wait 5 seconds before retrying
            retries += 1
        else:
            print(f"Unexpected status code: {response.status_code}")
            return None
    return None

def main():
    url = "https://www.amazon.com/s?k=airsoft+gun&crid=21BU2XYO6I2TG&sprefix=airsoft+gun%2Caps%2C113&ref=nb_sb_noss_1"
    print(f"Fetching the URL: {url}")
    response = fetch_page(url)
    if response and response.status_code == 200:
        print("Page content fetched successfully. Parsing product links...")
        urls = scrape_urls(response.text)
        if urls:
            with open("scraped_urls.txt", "w") as file:
                for url in urls:
                    file.write(url + "\n")
            print(f"Found {len(urls)} product URLs. Saved to 'scraped_urls.txt'.")
        else:
            print("No URLs were found on the page.")
    else:
        print("Failed to fetch the page after multiple attempts.")

if __name__ == "__main__":
    main()
    input("Press Enter to exit...")
