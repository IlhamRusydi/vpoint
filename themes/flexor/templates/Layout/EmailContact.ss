<% include EmailHeader %>

    <table>
      <tr>
        <td><% _t('Page.Name') %></td>
        <td> : </td>
        <td>$Name</td>
      </tr>
      <tr>
        <td>Email</td>
        <td> : </td>
        <td>$Email</td>
      </tr>
      <tr>
        <td><% _t('Page.Phone') %></td>
        <td> : </td>
        <td>$Phone</td>
      </tr>
      <tr>
        <td><% _t('Page.VisitorIP') %></td>
        <td> : </td>
        <td>$VisitorIP</td>
      </tr>
      <tr>
        <td><% _t('Page.Subject') %></td>
        <td> : </td>
        <td>$Subject</td>
      </tr>
      <tr>
        <td><% _t('Page.Message') %></td>
        <td> : </td>
        <td>$Message</td>
      </tr>
    </table>

<% include EmailFooter %>
