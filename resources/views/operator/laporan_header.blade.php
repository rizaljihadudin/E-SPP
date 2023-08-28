<div class="row">
    <table>
     <tr>
         <td width="85">
             <img src="{{ asset('logo/sdit.png') }}" style="width: 100%;" />
         </td>
         <td style="text-align: left;vertical-align:middle;" colspan="1">
             <div style="font-size:20px;font-weight:bold;">
                 {{ settings()->get('app_name') }}
             </div>
             <div>
                 {{ settings()->get('app_address') }}
             </div>
         </td>
     </tr>
     <tr>
         <td></td>
         <td></td>
         <td class="text-end">
             <span class="mx-1">
                 Email: {{ settings()->get('app_email') }}
             </span>
             |
             <span>
                 Telp: {{ settings()->get('app_phone') }}
             </span>
             &nbsp;&nbsp;&nbsp;
         </td>
     </tr>
    </table>
</div>
<hr class="p-0 m-0">
