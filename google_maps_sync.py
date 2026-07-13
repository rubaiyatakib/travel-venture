import sys
import base64
import requests

def main():
    if len(sys.argv) < 5:
        print("Usage: python google_maps_sync.py <WP_SITE_URL> <WP_USERNAME> <WP_APP_PASSWORD> <GOOGLE_MAPS_API_KEY> [SEARCH_QUERY]")
        print("\nArguments:")
        print("  WP_SITE_URL          Your live WordPress site URL (e.g. http://localhost/tripazai)")
        print("  WP_USERNAME          WordPress Admin Username")
        print("  WP_APP_PASSWORD      WordPress Application Password (generated from Users -> Profile)")
        print("  GOOGLE_MAPS_API_KEY  Your Google Maps/Places API Key")
        print("  SEARCH_QUERY         Optional. Query to search (default: 'Hotels in Kolatoli, Cox\'s Bazar')")
        sys.exit(1)
        
    wp_url = sys.argv[1].rstrip('/')
    username = sys.argv[2]
    app_password = sys.argv[3]
    api_key = sys.argv[4]
    query = sys.argv[5] if len(sys.argv) > 5 else "Hotels in Kolatoli, Cox's Bazar"
    
    endpoint = f"{wp_url}/wp-json/travel-venture/v1/sync-hotels"
    
    # Generate Basic Auth header
    auth_str = f"{username}:{app_password}"
    auth_bytes = auth_str.encode('utf-8')
    auth_b64 = base64.b64encode(auth_bytes).decode('utf-8')
    
    headers = {
        'Authorization': f'Basic {auth_b64}'
    }
    
    payload = {
        'api_key': api_key,
        'query': query
    }
    
    print(f"Connecting to WordPress REST API at: {endpoint}...")
    print(f"Search Query: {query}")
    
    try:
        response = requests.post(endpoint, headers=headers, data=payload)
        
        if response.status_code == 200:
            result = response.json()
            print("\n================================================")
            print("  GOOGLE MAPS TO WORDPRESS SYNC COMPLETE")
            print("================================================")
            print(f"Result: {result.get('summary')}")
            print(f"Created: {result.get('created')} | Updated: {result.get('updated')}")
            print("\nDetailed Logs:")
            for log in result.get('logs', []):
                print(f"  - {log}")
        else:
            print(f"\nError: Server returned status code {response.status_code}")
            try:
                err_data = response.json()
                print(f"Message: {err_data.get('message', 'No message provided')}")
                if 'code' in err_data:
                    print(f"Code: {err_data.get('code')}")
            except:
                print(response.text)
    except Exception as e:
        print(f"\nConnection Error: Failed to connect to WordPress site. {e}")

if __name__ == '__main__':
    main()
