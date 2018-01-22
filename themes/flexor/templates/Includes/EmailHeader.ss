<html>

  <head>
    <title></title>
  </head>

  <body bgcolor="#fff" style="background: #fff; color: #555; margin: 0; padding: 0; 
        font-family: Arial,Helvetica,sans-serif; font-weight: normal;">

    <!-- wrapper -->
    <table width="100%" bgcolor="#fff" cellpadding="0" style="background: #fff; padding: 20px;"><tr><td align="center">

          <!-- body -->
          <table id="layout_table" bgcolor="#fff" width="" border="0" cellpadding="0" cellspacing="0" 
                 style="background: #fff; border:1px solid #666; width: 100%; max-width: 620px;">

            <!-- header -->
            <tr>
              <td id="table_header" style="padding: 20px; text-align: center;">
                <!-- TODO -->
                <a href="$BaseHref">
                  <% if $SiteConfig.Logo %>
                  <img src="$SiteConfig.Logo.SetHeight(50).URL" style="border:none;"/>
                  <% else %>
                  $SiteConfig.Title
                  <% end_if %><br>
                </a>        
                <div style="border-bottom:1px solid #eee; margin:1em 0; padding:0;"></div>
              </td>
            </tr>
            <!-- end header -->

            <!-- content -->
            <tr>
              <td id="table_body" style="padding: 20px 20px 20px; font-size: 12px;">
                <!-- content start -->  