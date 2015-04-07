package burp;

import java.io.ByteArrayInputStream;

import java.io.ByteArrayOutputStream;
import java.io.InputStream;

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import javax.xml.transform.*;
import javax.xml.transform.stream.*;
import org.jvnet.fastinfoset.*;

import com.sun.xml.fastinfoset.sax.SAXDocumentSerializer;

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
					
					// split message body from headers
					Object[] httpMessage = HttpUtils.splitHttp(messageInfo.getRequest());
					byte[] headers = (byte[]) httpMessage[0]; // byte array of our headers
					byte[] body = (byte[]) httpMessage[1]; // byte array of our body
					String strHeaders = new String(headers); // string version of headers, much easier for later
									
					// do we need to re-encode??
					if (strHeaders.indexOf("EncodeMeMofo: true") > 1)
					{
						System.out.println("oo, we need to re-encode");
						
						// we need to re-encode the body of the message
						byte[] encodedMessage = encodeWCFDocument(body);

						// remove our custom HTTP header
						strHeaders.replaceAll("\r\nEncodeMeMofo: true", "");
						
						// we need to re-add our crlf
						strHeaders += "\r\n\r\n";
						
						// turn our string back into a byte[]
						byte[] newheaders = strHeaders.getBytes();
						
						// where we'll store our decoded FI document body
						byte[] processedMessage = new byte[newheaders.length + encodedMessage.length]; 
						
						// concatenate the headers and processed body together into processMessage byte[] array
						System.arraycopy(newheaders, 0, processedMessage, 0, newheaders.length);
						System.arraycopy(encodedMessage, 0, processedMessage, newheaders.length, encodedMessage.length);

						System.out.println(new String(processedMessage));
						
						
						// return the new byte array
						messageInfo.setRequest(processedMessage);
					}
					
	
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
						
						// add an HTTP header to specify re-encoding
						// we are sooooo going to cheat here
						strHeaders += "\r\nEncodeMeMofo: true";

						// we need to re-add our crlf
						strHeaders += "\r\n\r\n";
						
						byte[] newheaders = strHeaders.getBytes();
						
						// where we'll store our decoded FI document body
						byte[] processedMessage = new byte[newheaders.length + decodedMessage.length]; 
						
						// concatenate the headers and processed body together into processMessage byte[] array

						System.arraycopy(newheaders, 0, processedMessage, 0, newheaders.length);
						System.arraycopy(decodedMessage, 0, processedMessage, newheaders.length, decodedMessage.length);

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
    
    private byte[] encodeWCFDocument(byte[] message) throws Exception
    {
		InputStream xml = new ByteArrayInputStream(message); // create an InputStream from message byte array
		ByteArrayOutputStream fi = new ByteArrayOutputStream(); // creates a new ByteArrayOutputStream where we'll store encoded fastinfoset
		
    	System.out.println("I am encoding");
    	
    	// Create Fast Infoset SAX serializer
    	SAXDocumentSerializer saxDocumentSerializer = new SAXDocumentSerializer();
    	// Set the output stream
    	saxDocumentSerializer.setOutputStream(fi);

    	// Instantiate JAXP SAX parser factory
    	SAXParserFactory saxParserFactory = SAXParserFactory.newInstance();
    	/* Set parser to be namespace aware
    	 * Very important to do otherwise invalid FI documents will be
    	 * created by the SAXDocumentSerializer
    	 */
    	saxParserFactory.setNamespaceAware(true);
    	// Instantiate the JAXP SAX parser
    	SAXParser saxParser = saxParserFactory.newSAXParser();
    	// Set the lexical handler
    	saxParser.setProperty("http://xml.org/sax/properties/lexical-handler", saxDocumentSerializer);
    	// Parse the XML document and convert to a fast infoset document
    	saxParser.parse(xml, saxDocumentSerializer);
    	
    	// returns the fi doc as a byte[]
    	return fi.toByteArray();
    
    }
}
