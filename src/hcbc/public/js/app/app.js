//<![CDATA[
var $j = jQuery.noConflict();

$j(document).ready(function()
{
	$j(document).ajaxStart(function()
	{
	    $j('#ajax-loader').show();
	});
	
	$j(document).ajaxStop(function()
	{
	    $j('#ajax-loader').hide();
	});
	
	$j(document).on('submit', '.proc', function(event)
	{
		var _path = $j(this).attr('action');
		var _elemId = $j(this).attr('id');
		var _host = $j('#apiname').attr('data-host');
		var f = $j(this).serializeArray();
		f.push({name: $j('form#'+_elemId+' input:submit')
			.attr('id'), value: $j('form#'+_elemId+' input:submit')
			.val()
		});
		var data = $j.param(f);
		$j.post(
			_path,
			data,
			function(data, jqXHR, xhr) 
			{
				$j('#apiname').text(_host + _path);
				$j('#results').html(data);
			}
		);
      	return false;
	});
	
	$j(document).on('click', 'table tr', function ()
    {
        var _instance = $j(this);
        var _state = _instance.hasClass('row-sel');
        $j('.row-sel').removeClass('row-sel');
        if (!_state)
        {
            _instance.find('td').addClass('row-sel');
        }
    });
	
	$j('body').on('click', '.partial', function(event)
	{
		event.preventDefault();
		var _elemId = $j(this).attr('id');
		var _dest = _elemId.split("_", 1);
		var _path = $j(this).attr('href');
		$j.ajax(
		{
			type	: 'GET',
			url		: _path,
			async	: true,
			success	: function(data) 
			{
				$j('#'+_dest).html(data);
			},
            error: function (xhr) 
            {
                alert(xhr.responseText);
            }
		});
	});
});
//]]>