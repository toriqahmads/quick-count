$(document).ready(function()
{
    $("#tingkat").on("change", function()
    {
        var tingkat = $("#tingkat").val();
        if(tingkat === '0' || tingkat === null || tingkat === undefined || tingkat === 0 || tingkat == '')
        {
            showNotification('top', 'right','Harap pilih tingkat!', 'danger');
        }
        else
        {
        	var url = '';
        	if(tingkat == 'a')
        	{
        		url = window.location.origin+"/suara/register/presiden";
        	}
        	else if(tingkat == 'b')
        	{
        		url = window.location.origin+"/suara/register/dpd";
        	}
        	else if(tingkat == 'c')
        	{
        		url = window.location.origin+"/suara/register/dprri";
        	}
        	else if(tingkat == 'd')
        	{
        		url = window.location.origin+"/suara/register/dprprov";
        	}
        	else if(tingkat == 'e')
        	{
        		url = window.location.origin+"/suara/register/dprkab";
        	}

        	$("#form").prop('action', url);
        }
    });
});
