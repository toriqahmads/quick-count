$(document).ready(function()
{
  $("#tingkat").change(function()
    {
        var tingkat = $("#tingkat").val();
        if(tingkat === '0' || tingkat === null || tingkat === undefined || tingkat == '' || tingkat == 0)
        {
            window.location = window.location.origin+"/caleg/listcaleg";
        }
        else
        {
            window.location = window.location.origin+"/caleg/listcaleg/" + tingkat;
        }
        return false;
    });
});