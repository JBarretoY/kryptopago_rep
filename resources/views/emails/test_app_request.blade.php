<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
    <tbody>
        <tr>
            <td>
                <table width="520" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
                    
                    <tbody>
                        <tr valign="top">
                            <td style="padding-top:30px" align="center">
                                <a>
                                    <img src="https://sim.org.ve/storage/img_2018-07-11_6fe6df31aca0f7b561cf278497d80fa0.png" alt="Kryptopago" style="display:block;color:#162b4d" class="CToWUd" border="0" align="middle">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:10px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;color:#172b4d;font-weight:400;line-height:24px;font-size:16px;text-align:center" valign="top" align="center">
                                @lang('mail.commons.user', ['fn' => $user->first_name, 'ln' => $user->last_name])
                            </td>
                        </tr>
                        <tr valign="top">
                            <td style="padding-top:30px" align="center">
                                <a href="" target="_blank">
                                    <!-- <img style="display:block" src="https://ci6.googleusercontent.com/proxy/myhRp17PQv65YWduyb3Rd6v69WApwbMNmU6tMuLd4168BDbxoBbI2gMHcOQICy3F584D1OVsJtJvWH_s1SU_KJaJ5pxu76u1mY635HoHWhbnqlGGsD1ghXfUQDGkWt3MIeJvdZ8h1A63XMpND4KxoER19mfmfgYIWtw6aQ4G_UJkHM248GS0lzDlTp27_A=s0-d-e1-ft#https://aes-artifacts--cdn.us-east-1.prod.public.atl-paas.net/hashed/rs27nA2KElr0ZiNQYBZWOaYpZqOKXifZUCH0it5UeWc/429.png" class="m_7318642367642068450m_-5837181096912791778m_3880267595568648753hero CToWUd" width="360" height="auto" border="0"> -->
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding-top:30px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;color:#172b4b;font-size:14px;line-height:20px;text-align:left" valign="top" align="center">
                                <p>@lang('mail.test_app.content1')</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding-top:30px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;color:#172b4b;font-size:14px;line-height:20px;text-align:left" valign="top" align="center">
                                <p>@lang('mail.test_app.instructions')</p>
                                <ul>
                                    <li>@lang('mail.test_app.instructions1')</li>
                                    <li>@lang('mail.test_app.instructions2')</li>
                                    <li>@lang('mail.test_app.instructions3')</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <td valign="top" align="center">
                                <table style="margin-top:20px" cellspacing="0" cellpadding="0" border="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="border-radius:3px;background-color:#0052cc;height:40px;padding:0px 8px;color:#ffffff" align="center">
                                                <a href="{{ url("api/apps/$app->id/demo/download") }}" style="border:1px solid #0052cc;display:inline-block;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;font-size:14px;color:#ffffff;text-decoration:none;border-radius:3px;line-height:32px;letter-spacing:normal" target="_blank">
                                                    @lang('mail.test_app.download_button')
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding-top:30px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;color:#172b4b;font-size:14px;line-height:20px;text-align:left" valign="top" align="center">
                                <p>@lang('mail.test_app.expiration')</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding-top:10px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;color:#172b4d;font-weight:400;line-height:24px;font-size:16px;text-align:left" valign="top" align="center">
                                <p>@lang('mail.commons.greeting')</p>
                                <p>@lang('mail.commons.team')</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="padding-top:30px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;font-size:12px;line-height:24px;color:#5e6c84;text-align:center" valign="top" align="center">
                                <a href="" style="text-decoration:none;color:#5e6c84" target="_blank">@lang('mail.commons.unsubscribe')</a>  •
                                <a href="" style="text-decoration:none;color:#5e6c84" target="_blank">@lang('mail.commons.policy')</a> •
                                <a href="" style="text-decoration:none;color:#5e6c84" target="_blank">@lang('mail.commons.contact_us')</a> •
                                <a href="" style="text-decoration:none;color:#5e6c84" target="_blank">@lang('mail.commons.our_blog')</a> •
                                <a href="" style="text-decoration:none;color:#5e6c84" target="_blank">@lang('mail.commons.twitter')</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;font-size:12px;line-height:24px;color:#5e6c84;text-align:center" valign="top" align="center">
                                Copyright 2018 Simgulary
                            </td>
                        </tr>
                        <tr valign="top">
                            <td style="padding-top:10px;padding-bottom:30px" align="center">
                                <a href="" target="_blank">
                                    <!-- <img src="https://ci4.googleusercontent.com/proxy/5R8Wxi7vNj9Q43PnbcfYXN6uA7Hnb-R4HKL4fDxMGprZV_vvSTT9J3zb-mzpL-KsLxDjpFM2HxwKOMxWmmtJvEYg5zSwuTnmmWLpqAOLuoyxJ9lUFq8aXE7CYvaCiOdM-fCrnUiCx0cIDb5DlMXq2HU5x2t-XkSZN9YM7UuyMEo55z_M1uYIVApaCoKtY6KVtXM37CjvbZl2CJjpPGx5iESyXsCVmEyUTnpQUcsg4A=s0-d-e1-ft#https://aes-artifacts--cdn.us-east-1.prod.public.atl-paas.net/hashed/w0nfUVogWcPZZ9-70HwD15NtmivmDSyi_gKiY6Ol040/Atlassian-horizontal-neutral@2x-rgb.png" alt="Atlassian" style="display:block" class="CToWUd" width="120" border="0"> -->
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>