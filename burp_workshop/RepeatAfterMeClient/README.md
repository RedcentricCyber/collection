# RepeatAfterMeClient #

This is a simple command line exe which will send a Fastinfoset encoded SOAP message to the WCF endpoint defined in app.config. It is hardcoded to use a proxy server of http://localhost:8080 which should be your Burp instance.

You can change this location in the app.config if required.

It takes one argument, the value you'd like the WCF service to echo back.
