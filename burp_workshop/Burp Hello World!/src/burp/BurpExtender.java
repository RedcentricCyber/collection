package burp;

import burp.*;

public class BurpExtender
{
	public void processHttpMessage(
			String toolName,
			boolean messageIsRequest,
			IHttpRequestResponse messageInfo) throws Exception
			{
				System.out.println("Hello World!");
			}
}