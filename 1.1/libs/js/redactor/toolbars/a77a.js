if (typeof RTOOLBAR == 'undefined') 
	var RTOOLBAR = {};

RTOOLBAR['a77a'] = 
{
	
	bold:
	{ 
		title: RLANG.bold,
		exec: 'Bold',
	 	param: false	
	},
	italic:
	{
		title: RLANG.italic,
		exec: 'italic',
	 	param: null
	},
	fontcolor:
	{
		title: RLANG.fontcolor, 
		func: 'show'
	},	
	backcolor:
	{
		title: RLANG.backcolor, 
		func: 'show'
	},	
	styles:
	{ 
		title: RLANG.styles,
		func: 'show', 				
		dropdown: 
	    {
			 p:
			 {
			 	title: RLANG.paragraph,			 
			 	exec: 'formatblock',
			 	param: '<p>'
			 },
			 blockquote:
			 {
			 	title: RLANG.quote,
			 	exec: 'formatblock',	
			 	param: '<blockquote>',
			 	style: 'font-style: italic; color: #666; padding-left: 10px;'			 			 	
			 },
			 pre:
			 {  
			 	title: RLANG.code,
			 	exec: 'formatblock',
			 	param: '<pre>',
			 	style: 'font-family: monospace, sans-serif;'
			 },
			 h1:
			 {
			 	title: RLANG.header1,			 
			 	exec: 'formatblock',   
			 	param: '<h1>',			 	
			 	style: 'font-size: 18px; line-height: 20px; font-weight:normal;'
			 },
			 h2:
			 {
			 	title: RLANG.header2,			 
			 	exec: 'formatblock',   
			 	param: '<h2>',			 	
			 	style: 'font-size: 16px; line-height: 20px; font-weight:normal;'
			 },
			 h3:
			 {
			 	title: RLANG.header3,			 
			 	exec: 'formatblock', 
			 	param: '<h3>',			 	  
			 	style: 'font-size: 14px; line-height: 20px;  font-weight:normal;'
			 },		
			 h4:
			 {
			 	title: RLANG.header4,			 
			 	exec: 'formatblock', 
			 	param: '<h3>',			 	  
			 	style: 'font-size: 12px; line-height: 20px;  font-weight:normal;'
			 }					 														
		}
	},	
	insertunorderedlist:
	{
		title: '&bull; ' + RLANG.unorderedlist,
		exec: 'insertunorderedlist',
	 	param: null
	},
	insertorderedlist:
	{
		title: '1. ' + RLANG.orderedlist,
		exec: 'insertorderedlist',	
	 	param: null
	},
	justifyleft:
	{	
		exec: 'JustifyLeft', 
		name: 'JustifyLeft', 
		title: RLANG.align_left
	},					
	justifycenter:
	{
		exec: 'JustifyCenter', 
		name: 'JustifyCenter', 
		title: RLANG.align_center
	},
	justifyright: 
	{
		exec: 'JustifyRight', 
		name: 'JustifyRight', 
		title: RLANG.align_right
	},	
	justify: 
	{
		exec: 'justifyfull', 
		name: 'justifyfull', 
		title: RLANG.align_justify
	},	
	horizontalrule: 
	{
		exec: 'inserthorizontalrule', 
		name: 'horizontalrule', 
		title: RLANG.horizontalrule
	},	
	table: 					
	{ 
		title: RLANG.table,
		func: 'show', 				
		dropdown: 
		{
			insert_table: { name: 'insert_table', title: RLANG.insert_table, func: 'showTable' },
			separator_drop1: { name: 'separator' },	
			insert_row_above: { name: 'insert_row_above', title: RLANG.insert_row_above, func: 'insertRowAbove' },
			insert_row_below: { name: 'insert_row_below', title: RLANG.insert_row_below, func: 'insertRowBelow' },
			insert_column_left: { name: 'insert_column_left', title: RLANG.insert_column_left, func: 'insertColumnLeft' },
			insert_column_right: { name: 'insert_column_right', title: RLANG.insert_column_right, func: 'insertColumnRight' },												
			separator_drop2: { name: 'separator' },	
			add_head: { name: 'add_head', title: RLANG.add_head, func: 'addHead' },									
			delete_head: { name: 'delete_head', title: RLANG.delete_head, func: 'deleteHead' },							
			separator_drop3: { name: 'separator' },				
			delete_column: { name: 'insert_table', title: RLANG.delete_column, func: 'deleteColumn' },									
			delete_row: { name: 'delete_row', title: RLANG.delete_row, func: 'deleteRow' },									
			delete_table: { name: 'delete_table', title: RLANG.delete_table, func: 'deleteTable' }																		
		}								
	},
	link:
	{ 
		title: RLANG.link,
		func: 'show', 				
		dropdown: 
		{
			link:
			{
				title: RLANG.link_insert, 
				func: 'showLink'
			},
			unlink: 
			{
				title: RLANG.unlink,
				exec: 'unlink', 
			 	param: null
			}
		}													
	},
	image:
	{
		title: RLANG.image, 						
		func: 'showImage' 			
	},
	video:
	{
		title: RLANG.video,
		func: 'showVideo'
	},
	file:
	{
		title: RLANG.file,
		func: 'showFile'
	},/*	
	fullscreen:
	{
		title: RLANG.fullscreen,
		func: 'fullscreen'
	},*/
	html:
	{
		title: RLANG.html,
		func: 'toggle'
	}
};