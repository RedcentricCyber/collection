# Fastinfoset Decoder - Take One #

This plugin takes the byte[] containing the request, converts it to a String, splits on \r\n\r\n to separate headers and body then attempts to Fastinfoset decode the body.

It fails because FI documents are binary and we just converted it to a String.
