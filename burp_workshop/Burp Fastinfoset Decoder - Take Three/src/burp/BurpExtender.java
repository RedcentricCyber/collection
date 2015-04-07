package burp;

import java.io.ByteArrayInputStream;

import java.io.ByteArrayOutputStream;
import java.io.InputStream;

import javax.xml.transform.*;
import javax.xml.transform.stream.*;
import org.jvnet.fastinfoset.*;
import burp.HttpUtils;


public class BurpExtender
{
	public void processHttpMessage(
			String toolName,
			boolean messageIsRequest,
			IHttpRequestResponse messageInfo) throws Exception
			{
				if (messageIsRequest)
				{
					System.out.println("processHttpMessage (request) called by " + toolName);
				} else {
					System.out.println("processHttpMessage (response) called by " + toolName);
					

				}
			}
	
	public byte[] processProxyMessage(
			int MessageReference,
			boolean messageIsRequest,
			String remoteHost,
			int remotePort,
			boolean serviceIsHttps,
			String httpMethod,
			String url,
			String resourceType,
			String statusCode,
			String responseContentType,
			byte[] message,
			int[] action) throws Exception
			{
				if (messageIsRequest)
				{
					System.out.println("processProxyMessage (request) called for " + url);
					
					// split message body from headers
					Object[] httpMessage = HttpUtils.splitHttp(message);
					byte[] headers = (byte[]) httpMessage[0]; // byte array of our headers
					byte[] body = (byte[]) httpMessage[1]; // byte array of our body
					String strHeaders = new String(headers); // string version of headers, much easier for later
									
					// if we're application/fastinfoset you're our bag
					if (strHeaders.indexOf("Content-Type: application/fastinfoset") > 1)
					{
						// send to the decodeWCFDocument method
						byte[] decodedMessage = decodeWCFDocument(body);
						
						// we need to re-add our crlf
						byte[] crlf = "\r\n\r\n".getBytes();
						
						// where we'll store our decoded FI document body
						byte[] processedMessage = new byte[headers.length + crlf.length + decodedMessage.length]; 
						
						// concatenate the headers and processed body together into processMessage byte[] array

						System.arraycopy(headers, 0, processedMessage, 0, headers.length);
						System.arraycopy(crlf, 0, processedMessage, headers.length, crlf.length);
						System.arraycopy(decodedMessage, 0, processedMessage, headers.length+4, decodedMessage.length);

						// return the new byte array
						return processedMessage;
					}
				} else {
					System.out.println("processProxyMessage (response) called for " + url);
				}
				

				return message;
			}
	

	/*
     * Takes a message body (without headers) of content-type: application/fastinfoset and decodes it, 
     * returning a byte array of XML
     */
    private byte[] decodeWCFDocument(byte[] message) throws Exception
    {
		InputStream fi = new ByteArrayInputStream(message); // create an InputStream from message byte array
		ByteArrayOutputStream out = new ByteArrayOutputStream(); // creates a new ByteArrayOutputStream where we'll store XML
		
    	try {
			// Create the transformer
			Transformer tx = TransformerFactory.newInstance().newTransformer();
			
			// Transform to convert the FI document to an XML document
			tx.transform(new FastInfosetSource(fi), new StreamResult(out));
			
			// return the ByteArrayOutputStream as a byte array
			return out.toByteArray();
		} catch (Exception e) {
			System.out.println(e.getMessage().getBytes());
			return out.toByteArray();
		}
    }
}