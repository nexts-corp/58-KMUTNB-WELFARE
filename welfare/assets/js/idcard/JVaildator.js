function validateForms(form_name)
{
    var blnvalidate = true;
    if (!document.getElementsByTagName)
        return false;
    elementsForms = document.getElementsByTagName('span');
    for (var intCounter = 0; intCounter < elementsForms.length; intCounter++)
    {
        //	alert(elementsForms[intCounter].id);
        //VALIDATE_isnull_type_formname_controlname
        //VALIDATE_Y_TB_Signup_PROVINCEID

        var wname = elementsForms[intCounter].id;
        var mname = wname.split("_");

        if (mname[0] == "VALIDATE")
        {
            if (form_name == mname[3])
            {
                if (mname[1] == "Y")
                {
                    try {
                        var v = document.getElementById(mname[4]).value;
                        eval("v=format" + mname[2] + "(v,wname)");
                        /*if(mname[2]=="String"){
                         v=document.getElementById(mname[4]).value;
                         v=formatString(v,mname[4]);
                         }else if(mname[2]=="Date"){
                         v=document.getElementById(mname[4]).value;
                         v=formatString(v,mname[4]);
                         }
                         else if(mname[2]=="Time"){
                         v=document.getElementById(mname[4]).value;
                         v=formatString(v,mname[4]);
                         }
                         else if(mname[2]=="Post"){
                         v=document.getElementById(mname[4]).value;
                         v=formatString(v,mname[4]);
                         }
                         else if(mname[2]=="ChkInteger"){
                         v=document.getElementById(mname[4]).value;
                         v=formatString(v,mname[4]);
                         }
                         else if(mname[2]=="PersonId"){
                         v=document.getElementById(mname[4]).value;
                         v=formatPersonId(v,mname[4]);
                         }
                         else if(mname[2]=="Telphone"){
                         v=document.getElementById(mname[4]).value;
                         v=formatTelphone(v,mname[4]);
                         }
                         else if(mname[2]=="Email"){
                         v=document.getElementById(mname[4]).value;
                         v=formatEmail(v,mname[4]);
                         }
                         else if(mname[2]=="Decimal"){
                         v=document.getElementById(mname[4]).value;
                         v=formatDecimal(v,mname[4]);
                         }*/
                        if (v == "" || v == null || v == undefined)
                        {
                            blnvalidate = false;
                        }
                    } catch (err) {
                        //alert(wname);
                        //alert(err);
                    }

                    //Text box
                    /*if(mname[2]=="TB")
                     {
                     var v=document.getElementById(mname[4]).value;
                     //       alert(v);
                     if(v=="" || v==null || v== undefined)
                     {
                     if(blnvalidate){
                     blnvalidate=false;
                     }
                     elementsForms[intCounter].innerHTML ="<FONT COLOR=\"#FF0000\">* �?รุณา�?รอ�?�?�?อมูล</FONT>";
                     }
                     else{
                     elementsForms[intCounter].innerHTML ="";
                     }
                     }*/


                }

            }
        }

    }
    return blnvalidate;
}
function formatTB(v, vilidateName) {
    //alert(v);
    if (v == "" || v == null || v == undefined)
    {
        document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">* �?รุณา�?รอ�?�?�?อมูล</FONT>";
        return "";
    } else {
        document.getElementById(vilidateName).innerHTML = "";
        return v;
    }
}
function formatDate(date, vilidateName) {
//	alert(date);
    var dateformat = /^\d{1,4}(\-|\/|\.)\d{1,2}\1\d{2}$/;

    if (!dateformat.test(date))
    {
        document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">* Ex. yyyy-mm-dd</FONT>";
        return "";
    }
    else
    {
        document.getElementById(vilidateName).innerHTML = "";
        return date;
    }
}
function formatTime(Time, vilidateName) {
//	alert(date);
    var timeformat = /^\d{2}(\:)\d{2}$/;

    if (!timeformat.test(Time))
    {
        document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">* Ex. 10:00 </FONT>";
        return "";
    }
    else
    {

        document.getElementById(vilidateName).innerHTML = "";
        return date;
    }
}
function formatString(v, vilidateName) {
    if (v == "" || v == null || v == undefined)
    {
        document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">* �?รุณา�?รอ�?�?�?อมูล</FONT>";
        return "";
    } else {
        document.getElementById(vilidateName).innerHTML = "";
        return v;
    }
}
//Make by somchit 
//Make date 2011-05-03 
function formatPost(string, vilidateName) {
//	alert(string.length);
    if (string.length != 5)
    {
        document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">* �?รุณา�?ส�?�?�?อมูล�?ห�?�?ร�?</FONT>";
        return "";
    }
    else
    {

        var digit;

        for (var i = 0; i < string.length; i++)
        {
            digit = string.charAt(i)
            if (digit >= "0" && digit <= "9") {
                ;
            } else {
                document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">* �?ส�?ตัวเล�?เท�?า�?ั�?�?</FONT>";
                return "";
            }
        }
        document.getElementById(vilidateName).innerHTML = "";
        return string;


    }
}
function formatChkInteger(string, vilidateName) {
//	alert(string.length);

    var digit;

    for (var i = 0; i < string.length; i++)
    {
        digit = string.charAt(i)
        if (digit >= "0" && digit <= "9") {
            ;
        } else {
            document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">* �?ส�?ตัวเล�?เท�?า�?ั�?�?</FONT>";
            return "";
        }
    }
    document.getElementById(vilidateName).innerHTML = "";
    return string;

}

function formatPersonId(pid) {
//	alert(pid.length);
    if (pid.length != 13)
    {
        //document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">length < 13</FONT>";
        return "";
    }
    else
    {
        var sum = 0;
        var chk = false;
        var i = 0;

        for (i = 0; i < 12; i++)
        {
            var d = parseInt(pid[i]);
            //	alert(d);
            sum = sum + d * (13 - i);
        }
        var digit = parseInt(pid[12]);
        var chkdigit = (11 - (sum % 11)) % 10;
        if (digit == chkdigit)
        {
           // document.getElementById(vilidateName).innerHTML = "";
            return pid;
        }
        else {
           // document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">�?ม�?ถู�?ต�?อ�?</FONT>";
            return "";
        }
    }
}

function formatTelphone(phone, vilidateName) {
//	alert(date);
    var phoneformat = /^\d{2,3}(\-)\d{7}$/;

    if (!phoneformat.test(phone))
    {
        document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">* Ex.089-1234567</FONT>";
        return "";
    }
    else
    {

        document.getElementById(vilidateName).innerHTML = "";
        return phone;
    }
}

function formatEmail(email, vilidateName)
{
    //alert(email);
    //alert(vilidateName);
    var emailFilter = /^.+@.+\..{2,3}$/;
    if (!emailFilter.test(email))
    {
        document.getElementById(vilidateName).innerHTML = "<FONT COLOR=\"#FF0000\">* Ex. name@email.com</FONT>";
        return "";
    }
    else
    {
        document.getElementById(vilidateName).innerHTML = "";
        return email;
    }
}

function formatDecimal(num, vilidateName) {
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' +
                num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + '.' + cents);
}

function formatInteger(num, vilidateName) {
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '' +
                num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num);
}

function removecomma(s) {
    var r = "";
    var i;
    for (i = 0; i < s.length; i++) {
        if (s.substr(i, 1) != ',') {
            r = r + s.substr(i, 1);
        }
    }
    return r;
}

function ConfirmDelete()
{
    if (confirm('�?ุณต�?อ�?�?ารที�?�?ะล�?�?�?อมูล�?�?�?หรือ�?ม�??'))
        return true;
    else
        return false;
}

function ConfirmDel()
{
    if (confirm("�?ุณต�?อ�?�?ารล�?�?�?อมูล�?�?�?หรือ�?ม�?"))
        return true;
    else
        return false;
}
function ConfirmMsg(msg)
{
    if (confirm(msg))
        return true;
    else
        return false;
}
function enableObject(ObjectName, ObjectFiledname, ObjectFiledTitle)
{
//alert(ObjectName);
    if (document.getElementById(ObjectName).style.display == "none")
    {
        document.getElementById(ObjectName).style.display = "block";
        document.getElementById(ObjectName + "_name").value = ObjectFiledname;
        document.getElementById(ObjectName + "_title").value = ObjectFiledTitle;

    }
    else
    {
        document.getElementById(ObjectName).style.display = "none";
        document.getElementById(ObjectName + "_name").value = "";
        document.getElementById(ObjectName + "_title").value = "";
    }

}
function enableAction(ObjectName)
{
    Option = document.getElementById(ObjectName + "_action").value;
    if (Option == "between")
    {
        document.getElementById(ObjectName + "_value1").style.display = 'block';
        document.getElementById(ObjectName + "_value2").style.display = 'block';
    }
    else if (Option == "is null")
    {
        document.getElementById(ObjectName + "_value1").style.display = 'none';
        document.getElementById(ObjectName + "_value2").style.display = 'none';
    }
    else if (Option == "is not null")
    {
        document.getElementById(ObjectName + "_value1").style.display = 'none';
        document.getElementById(ObjectName + "_value2").style.display = 'none';
    }
    else
    {
        document.getElementById(ObjectName + "_value1").style.display = 'block';
        document.getElementById(ObjectName + "_value2").style.display = 'none';
    }

}




