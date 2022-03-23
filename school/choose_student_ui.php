<?php
function choose_student_ui($title, $url, $con) {
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'
    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
 <head>
  <title>AcadBase</title>
  <link rel="stylesheet" type="text/css" href="js/themes/base/jquery.ui.all.css">
  <link rel='stylesheet' type='text/css' href="css/tablesorter/style.css" media="print, projection, screen" />	
  <link rel="stylesheet" href="js/themes/base/jquery.ui.all.css">
  
  <style>
	body { font-size: 62.5%;}
	label { float: left; clear: left; width: 7em; }

	input.text { margin:6px 0; width:30%; padding: 0.5em; }
	h1 { font-size: 1.2em; margin: .6em 0; }
	.ui-dialog .ui-state-error { padding: .3em; }
	.validateTips { border: 1px solid transparent; padding: 0.3em; }
	
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
	.inline {position:absolute; top:9em; left:40em;}
	
  </style>
  
  <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
  <script src="js/ui/jquery.ui.core.js"></script>
  <script src="js/ui/jquery.ui.widget.js"></script>
  <script src="js/ui/jquery.ui.datepicker.js"></script>
  <script src="js/ui/jquery.ui.mouse.js"></script>
  <script src="js/ui/jquery.ui.button.js"></script>
  <script src="js/ui/jquery.ui.draggable.js"></script>
  <script src="js/ui/jquery.ui.position.js"></script>
  <script src="js/ui/jquery.ui.resizable.js"></script>
  <script src="js/ui/jquery.ui.dialog.js"></script>
  <script src="ui/jquery.effects.core.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
	
  <script type='text/javascript' src='js/jquery.tablesorter.min.js'></script>
  <script type='text/javascript' src='js/jquery.tablesorter.pager.js'></script>
  <script type='text/javascript' src='js/chili-1.8b.js'></script>
  <script type='text/javascript' src='js/docs.js'></script>
  
   
  <script language='javascript' src='js/school.js'></script>
  <script type="text/javascript" src="js/custom.js"></script>
  <script>
  $(function() {
  
  var counter = $("#counter");
  
  // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
  $( "#dialog:ui-dialog" ).dialog( "destroy" );
		
  var student_name = $( "#student_name" ),
   allFields = $( [] ).add( student_name ),
   tips = $( ".validateTips" );

   function updateTips( t ) {
     tips
	   .text( t )
	   .addClass( "ui-state-highlight" );
	 setTimeout(function() {
	   tips.removeClass( "ui-state-highlight", 1500 );
	 }, 500 );
   }

	function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "Length of " + n + " must be between " +
				min + " and " + max + "." );
			return false;
		} else {
			return true;
		}
	}

	function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} else {
			return true;
		}
	}
	
	$.widget( "ui.student_name", {
	  _create: function() {
	    var self = this,
		select = this.element.hide(),
		selected = select.children( ":selected" ),
		value = selected.val() ? selected.text() : "";
		
		var input = this.input = $( "<input style='display:inline;' size='50'>" )
		  .insertAfter( select )
		  .val( value )
		  .autocomplete({
			delay: 0,
			minLength: 0,
			source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( select.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text.replace(
								new RegExp(
									"(?![^&;]+;)(?!<[^<>]*)(" +
									$.ui.autocomplete.escapeRegex(request.term) +
									")(?![^<>]*>)(?![^&;]+;)", "gi"
								), "<strong>$1</strong>" ),
							value: text,
							option: this
						};
				}) );
			},
			select: function( event, ui ) {
				ui.item.option.selected = true;
				self._trigger( "selected", event, {
					item: ui.item.option
				});
			},
			change: function( event, ui ) {
				if ( !ui.item ) {
					var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
						valid = false;
					select.children( "option" ).each(function() {
						if ( $( this ).text().match( matcher ) ) {
							this.selected = valid = true;
							return false;
						}
					});
					if ( !valid ) {
						// remove invalid value, as it didn't match anything
						$( this ).val( "" );
						select.val( "" );
						input.data( "autocomplete" ).term = "";
						return false;
					}
				}
			}
		  })
		.addClass( "ui-widget ui-widget-content ui-corner-left" );

		input.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + item.label + "</a>" )
				.appendTo( ul );
		};

		this.button = $( "<button style='display:inline;' type='button'>&nbsp;</button>" )
			.attr( "tabIndex", -1 )
			.attr( "title", "Show All Items" )
			.insertAfter( input )
			.button({
				icons: {
					primary: "ui-icon-triangle-1-s"
				},
				text: false
			})
			.removeClass( "ui-corner-all" )
			.addClass( "ui-corner-right ui-button-icon" )
			.click(function() {
				// close if already visible
				if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
					input.autocomplete( "close" );
					return;
				}

				// work around a bug (likely same cause as #5265)
				$( this ).blur();

				// pass empty string as value to search for, displaying all results
				input.autocomplete( "search", "" );
				input.focus();
			});
		},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	

	$(function() {
		$( "#student_name" ).student_name();
		$( "#toggle" ).click(function() {
		$( "#student_name" ).toggle();
		});
	});
	

	
	$( "#dialog-form" ).dialog({
		autoOpen: true,
		height: 200,
		width: 500,
		modal: true,
		buttons: {
			"OK": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );

				bValid = bValid && checkLength( student_name, "student_name", 1, 300 );

				if ( bValid ) {
					$( "#users tbody" ).append( "<tr>" +
						"<td>" + student_name.val() + "</td>" + 
					"</tr>" ); 
					
				  document.form1.submit();
				  //$( this ).dialog( "close" );
				  
				}
			},
			Cancel: function() {
				$( this ).dialog( "close" );
				location.href='student.php';
			},
		},
		close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );
			location.href='student.php';
		}
	});
  });
  </script>
 </head>
 <body>
  <div id="dialog-form" title="<?php echo $title; ?>">
  
  <form name='form1' id='form1' action='<?php echo $url; ?>' method='POST'>
   <div class='class1'><span class='style9'><h2><?php echo $title; ?></h2></span></div>
   <input type='hidden' name='action' value='Submit' />
	
   <div>
	 <label>Student: </label>
      <select id="student_name" name='student_name'>
	   <option value="">Select one...</option>
	    <?php
		$sql="select * from student s join student_temp_{$_SESSION['sessid']} st on s.id = st.student_id 
		  where st.class_id = {$_SESSION['class_id']} and s.school_id={$_SESSION['school_id']}";
		$result = mysqli_query($con, $sql) or die(mysqli_error($con));
		while($row = mysqli_fetch_array($result)) { 
		  echo "<option value='{$row['admission_number']}_{$row['firstname']}_{$row['lastname']}'>{$row['admission_number']}_{$row['firstname']}_{$row['lastname']}</option>";
		}
		?>
	  </select>
    </div>
      
	<div><a href='student.php?action=Add'>Add Student</a></div>
   </form>
  </div>
 </body>
</html>
<?php
}
?>