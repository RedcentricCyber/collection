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
					
					// split message body from headers
					Object[] httpMessage = HttpUtils.splitHttp(messageInfo.getResponse());
					byte[] headers = (byte[]) httpMessage[0];
					byte[] body = (byte[]) httpMessage[1];
					
					// send to the decodeWCFDocument method
					byte[] decodedMessage = decodeWCFDocument(body);
					System.out.println(new String(decodedMessage));
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