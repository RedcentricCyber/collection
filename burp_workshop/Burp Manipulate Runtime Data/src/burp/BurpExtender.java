package burp;

import burp.*;

public class BurpExtender
{
	public void processHttpMessage(
			String toolName,
			boolean messageIsRequest,
			IHttpRequestResponse messageInfo) throws Exception
			{
				if (messageIsRequest)
				{
					// we're going to change any occurrence of the word script to tpircs
					String str = new String(messageInfo.getRequest()); // this uses system default encoding which may not be what we want
					//System.out.println(str);
					String result = str.replaceAll("script", "tpircs" );
					byte[] request = result.getBytes();
					messageInfo.setRequest(request);
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
					//System.out.println("processProxyMessage (request) called for " + url);
				} else {
					//System.out.println("processProxyMessage (response) called for " + url);
				}
				
				return message;
			}
}