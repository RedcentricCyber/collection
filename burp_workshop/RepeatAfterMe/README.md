# RepeatAfterMe WCF Service #
Install this into an ApplicationPool on IIS or run out of Visual Studio (Express works too).

It's a very simple service which accepts Fastinfoset encoded SOAP requests and responds with an echo of the input. Don't run this in production or on a server in your domain as it's a great little XSS vulnerability. :-)
