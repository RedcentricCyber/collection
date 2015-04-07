using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.ServiceModel;

namespace RepeatAfterMeClient
{
    class Program
    {
        static void Main(string[] args)
        {
            string[] argv = Environment.GetCommandLineArgs();

            if (argv == null)
            {
                Console.WriteLine("Please specify an argument for me to send");
            }
            else
            {

                RepeaterServiceClient client = new RepeaterServiceClient();

                try
                {
                    Console.WriteLine(client.SayWhat(argv[1]));
                }
                catch (Exception)
                {
                    Console.WriteLine("Bugger, that didn't work");
                    Console.ReadLine();
                }               
            }
        }
    }
}
