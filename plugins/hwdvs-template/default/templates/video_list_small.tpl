{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2011 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<div class="box">
	<div class="listThumbnail" style="float:left;position:relative;">{$data->thumbnail}</div>
	<div>
		{if $hwdvsTemplateOverride.show_title eq 1}<div><strong>{$data->title}</strong> {$data->editvideo} {$data->deletevideo}</div>{/if}
		{if $hwdvsTemplateOverride.show_views eq 1}<div style="font-style:italic;font-size:90%;">{$data->views} {$smarty.const._HWDVIDS_INFO_VIEWS}</div>{/if}
     	</div>
	<div style="clear:both;"></div>
</div>