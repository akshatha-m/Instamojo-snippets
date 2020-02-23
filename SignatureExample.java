
import java.util.*;
import java.lang.*;
import javax.crypto.Mac;
import javax.crypto.spec.SecretKeySpec;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.SignatureException;

public class SignatureExample {

    public static void main (String[] args){
        String salt = "65ace02471ccb27831e9eb02a6fe8755";

        HashMap<String, String> data = new HashMap<>();
        data.put("data_amount", "1000");
        data.put("data_email", "foo@bar.com");
        data.put("data_phone", "1234567890");
        data.put("data_name", "Instamojo");
        data.put("data_Field_86555", "ORDER666");

        try {
            String result = Signature.getSignature(data, salt);
            System.out.println(result);
        } catch (Exception e) {
            e.printStackTrace();
            //oops something went wrong. Handle the scenario.
        }
    }

}

class Signature{

    private static final String DELIMITER = "|";
    private static final String FORMATTER = "%02x";
    private static final String ALGORITHM = "HmacSHA1";

    /**
     *
     * @param data - Map object
     * @param salt - salt for SHAHash
     * @return Hash of the object
     *
     */
    public static String getSignature( Map<String, String> data, String salt)
            throws SignatureException, NoSuchAlgorithmException, InvalidKeyException{

        if (data == null){
            throw new RuntimeException("Map is null");
        }

        if (salt == null){
            throw new RuntimeException("Salt is null");
        }

        ArrayList<String> sortedKeys = new ArrayList<>();
        sortedKeys.addAll(data.keySet());
        Collections.sort(sortedKeys, String.CASE_INSENSITIVE_ORDER);

        // No one liner to Join the strings till Java7. Available from Java8
        String message = null;
        for (String sortedKey : sortedKeys) {
            if (message == null){
                message = data.get(sortedKey);
                continue;
            }
            message += DELIMITER + data.get(sortedKey);
        }

        if (message == null){
            throw new RuntimeException("Map is Empty");
        }

        
	
	// Get hash
        SecretKeySpec signingKey = new SecretKeySpec(salt.getBytes(), ALGORITHM);
        Mac mac = Mac.getInstance(ALGORITHM);
        mac.init(signingKey);
        return toHexString(mac.doFinal(message.getBytes()));
    }

    private static String toHexString(byte[] bytes) {
        Formatter formatter = new Formatter();
        for (byte b : bytes) {
            formatter.format(FORMATTER, b);
        }
        return formatter.toString();
    }

}
