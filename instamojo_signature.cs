/*
Author: Ashwini Chaudhary
Program for generating Instamojo's tamper-proof signature.
*/

using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Security.Cryptography;
using System.IO;

namespace Instamojo
{
    class Sha1HashProgram
    {
        static string MsgCreator(Dictionary<string,string> data){
            var ordered_view = data.OrderBy(key => key.Key.ToLower());
            string message = "";
            
            foreach (var item in ordered_view)
            {
                message += item.Value + "|";
            }
            return message.Substring(0, message.Length - 1);
            
        }
        
        static void Main(string[] args)
        {
            string salt = "< Your salt here >"; // Salt
            
            /*
            The data dictionary should contain all the read-only fields.
            If you want to include custom field as well then add them to
            the dictionary, but don't forget to add "data_" in front of
            the custom field names. 
            */
            
            Dictionary<string, string> data = new Dictionary<string, string>()
            {
                {"data_amount", "1000" },
                {"data_email", "foo@bar.com"},
                {"data_phone", "1234567890"},
                {"data_name", "Instamojo"},
                //{"data_Field_86555", "ORDER666"} example...
            };
            
            string msg = MsgCreator(data);
            string signature = ShaHash(msg, salt);
            Console.WriteLine(signature);
        }

        static string ShaHash(string msg, string salt)
        {
            using (var hmac = new HMACSHA1(Encoding.ASCII.GetBytes(salt)))
            {
                return ByteToString(hmac.ComputeHash(Encoding.ASCII.GetBytes(msg)));
            }
        }

        static string ByteToString(IEnumerable<byte> msg)
        {
            return string.Concat(msg.Select(b => b.ToString("x2")));
        }
        
 }
 
}