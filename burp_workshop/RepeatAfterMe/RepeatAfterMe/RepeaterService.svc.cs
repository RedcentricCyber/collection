using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.ServiceModel.Web;
using System.Text;

namespace RepeatAfterMe
{
    public class RepeaterService : IRepeaterService
    {
        public string SayWhat(string value)
        {
            return string.Format("You said: {0}", value);
        }
    }
}
