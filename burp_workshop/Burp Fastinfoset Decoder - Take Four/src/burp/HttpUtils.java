package burp;

public class HttpUtils {
	public static Object[] splitHttp(byte[] message)
	{
		// have to split on bytes
		byte[] pattern = { (byte) 13, (byte) 10, (byte) 13, (byte) 10 }; // decimal for \r\n\r\n
		
		// find the end of the headers in the byte array - returns offset
		int hlen = BinarySearch.indexOf(message, pattern);
		
		int rlen = (message.length-hlen)-4; // body length
		
		// store the headers
		byte[] headers = new byte[hlen];
		
		// store the body
		byte[] body = new byte[rlen];
		int blen = body.length;
		
		if (hlen == -1)
		{
			// -1 is no match - this should never happen as it would break RFCs
			// and we aren't handling it here so it'd be bad
		} else {
			// return an array of two elements, headers and body
			System.arraycopy(message, 0, headers, 0, hlen);
			System.arraycopy(message, hlen+4, body, 0, blen);
		}
			
		Object httpMessage[] = new Object[2];
		httpMessage[0] = headers;
		httpMessage[1] = body;
		return httpMessage;
	}
}
