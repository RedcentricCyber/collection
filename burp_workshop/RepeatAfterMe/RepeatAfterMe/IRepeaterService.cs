using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.ServiceModel.Web;
using System.Text;

namespace RepeatAfterMe
{
    [ServiceContract]
    public interface IRepeaterService
    {

        [OperationContract]
        string SayWhat(string value);

    }
}
