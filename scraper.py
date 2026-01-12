import asyncio
import json
import sys
import random
from datetime import datetime
# Pastikan install: pip install twikit textblob
from twikit import Client
from textblob import TextBlob

COOKIES_FILE = 'cookies.json'
TARGET = 300 # Target per kebijakan

async def main():
    client = Client('en-US')
    try:
        client.load_cookies(COOKIES_FILE)
    except:
        print("Error: Cookies tidak ditemukan.")
        sys.exit(1)

    if len(sys.argv) < 2: sys.exit(1)
    policies = json.loads(sys.argv[1])
    results = []

    for p in policies:
        print(f"Processing: {p['title']}...")
        count = 0
        tweets = None
        
        while count < TARGET:
            try:
                if tweets is None:
                    tweets = await client.search_tweet(p['keyword_query'], product='Top')
                else:
                    tweets = await tweets.next()
                
                if not tweets: break

                for t in tweets:
                    # Analisis Sentimen Simpel
                    blob = TextBlob(t.text)
                    score = blob.sentiment.polarity
                    label = 'Netral'
                    if score > 0.1: label = 'Positif'
                    elif score < -0.1: label = 'Negatif'

                    scraped_at = datetime.now().isoformat()

                    results.append({
                        'policy_id': p['id'],
                        'tweet_id': t.id,
                        'full_text': t.text,
                        'username': t.user.name,
                        'likes': t.favorite_count,
                        'retweets': t.retweet_count,
                        'created_at_twitter': t.created_at,
                        'scraped_at': scraped_at,  # Tanggal & waktu scraping
                        'sentiment_score': score,
                        'sentiment_label': label
                    })
                    count += 1
                    if count >= TARGET: break
                
                await asyncio.sleep(random.randint(2, 4)) # Anti-ban delay
            except Exception as e:
                print(f"Error: {e}")
                break

    print(json.dumps(results)) # Output JSON ke Terminal

if __name__ == "__main__":
    asyncio.run(main())