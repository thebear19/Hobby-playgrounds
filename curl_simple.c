#include <stdio.h>
#include <stdlib.h>
#include <curl/curl.h> //HTTP_ONLY

struct responseBody {
	char *messages;
	size_t size;
};

static size_t responseCallBack(void *ptr, size_t size, size_t nmemb, void *stream){
    size_t realSize = size * nmemb;
    struct responseBody *res = (struct responseBody*)stream;

    res->messages = realloc(res->messages, res->size + realSize + 1);
    if(res->messages == NULL){
    	printf("not enough memory (realloc returned NULL)\n");
    	return 0;
    }

    memcpy(&(res->messages[res->size]), ptr, realSize);
    res->size += realSize;
    res->messages[res->size] = 0;

    return realSize;
}

int main(void){
	CURL *curl;
	CURLcode res;

	struct responseBody result;
	result.messages = malloc(1);
	result.size = 0;

	curl_global_init(CURL_GLOBAL_ALL);

	curl = curl_easy_init();
	if(curl) {
		curl_easy_setopt(curl, CURLOPT_CONNECTTIMEOUT, 20L);
		curl_easy_setopt(curl, CURLOPT_TIMEOUT, 20L);

		//HTTP_GET
		//curl_easy_setopt(curl, CURLOPT_URL, "http://localhost:8080/webservices/services/getProductList");

		//curl_easy_setopt(curl, CURLOPT_URL, "http://localhost:8080/webservices/services/getClientName?id=52282");

		//HTTP_POST
		/*curl_easy_setopt(curl, CURLOPT_URL, "http://localhost:8080/webservices/services/insertNewClientAccount?accountId=666675&accountName=test10");
		curl_easy_setopt(curl, CURLOPT_POST, 1L);
		curl_easy_setopt(curl, CURLOPT_POSTFIELDS, "");*/

		//HTTP_PUT
		curl_easy_setopt(curl, CURLOPT_URL, "http://localhost:8080/webservices/services/updateNewClientAccount"
				"?clientId=50326&accountName=rest1");
		curl_easy_setopt(curl, CURLOPT_UPLOAD, 1L);
		curl_easy_setopt(curl, CURLOPT_INFILESIZE_LARGE, (curl_off_t)0);

		curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, responseCallBack);
		curl_easy_setopt(curl, CURLOPT_WRITEDATA, (void *)&result);

		curl_easy_setopt (curl, CURLOPT_VERBOSE, 1L);

		res = curl_easy_perform(curl);
		if(res != CURLE_OK){
			fprintf(stderr, "curl_easy_perform() failed: %s\n", curl_easy_strerror(res));
		}else{
			printf("%lu bytes retrieved\n", (long)result.size);
			printf("%s\n\n", result.messages);
		}
		curl_easy_cleanup(curl);
	}
	free(result.messages);
	curl_global_cleanup();
	return 0;
}
