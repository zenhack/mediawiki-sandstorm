package main

import (
	"io"
	"log"
	"net"
	"net/http"
	"strings"
)

func main() {
	// Create an http.RoundTripper that ignores the host and always
	// connects to the local server.
	transport := &http.Transport{
		Dial: func(network, addr string) (net.Conn, error) {
			return net.Dial("tcp", "127.0.0.1:8000")
		},
	}

	http.HandleFunc("/", func(w http.ResponseWriter, req *http.Request) {
		log.Printf("Got request for %q", req.URL)
		if req.Method == "CONNECT" {
			log.Printf("error: proxy can't handle CONNECT requests.")
			w.WriteHeader(500)
			return
		}
		if !strings.HasPrefix(req.URL.Host, "ui-") {
			log.Print(
				"error: proxy only knows how to talk to the local " +
					"grain.",
			)
			w.WriteHeader(500)
		}

		// This field is supposed to be clear for client-side requests;
		// the stdlib will complain if it is present:
		req.RequestURI = ""
		resp, err := transport.RoundTrip(req)
		if err != nil {
			log.Printf("proxy request failed: %v\n", err)
			w.WriteHeader(500)
			return
		}
		copyResponse(w, resp)
	})
	panic(http.ListenAndServe(":6000", nil))
}

func copyResponse(w http.ResponseWriter, resp *http.Response) {
	defer resp.Body.Close()
	wh := w.Header()
	for k, v := range resp.Header {
		wh[k] = v
	}
	w.WriteHeader(resp.StatusCode)
	io.Copy(w, resp.Body)
}
