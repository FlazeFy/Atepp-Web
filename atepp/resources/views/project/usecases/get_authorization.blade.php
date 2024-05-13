<div class="">
    <h1 class="fw-bold mb-2">Authorization</h1>
    <select name="auth_method" class="form-select" id="auth_method" onchange="select_auth_method(this)">
        <option value="no_auth">No Auth</option>
        <option value="basic_auth">Basic Auth</option>
        <option value="bearer_token">Bearer Token</option>
        <option value="jwt_bearer">JWT Bearer</option>
        <option value="digest_auth">Digest Auth</option>
        <option value="oauth_1">OAuth 1.0</option>
        <option value="oauth_2">OAuth 2.0</option>
        <option value="hawk_authentication">Hawk Authentication</option>
        <option value="aws_signature">AWS Signature</option>
        <option value="ntlm_authentication">NTLM Authentication</option>
        <option value="api_key">API Key</option>
        <option value="asap_atlassian">ASAP (Atlassian)</option>
    </select>
    <div id="form_auth"></div>
</div>

<script>
    function select_auth_method(input){
        const val = input.value

        if(val == 'bearer_token'){
            $("#form_auth").empty().append(`
                <label>Token</label>
                <input type="text" class="form-control" id="bearer_token_auth">
            `)
        }
    }
</script>