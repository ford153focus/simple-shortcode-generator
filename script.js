function manual_hash_block() {
    if (document.querySelector('[value="set-short-manually"]').checked) {
        document.getElementById("manual-hash-block").style.display = "block";
    } else {
        document.getElementById("manual-hash-block").style.display = "none";
    }
}

jQuery(document).ready(function () {
    manual_hash_block();
});

document.querySelector('[value="set-short-manually"]').onclick = manual_hash_block;

jQuery("form").submit(function (event) {
    event.preventDefault();
    jQuery.get(
        "/generate.php",
        {
            url: jQuery(this).find("#inputURL").val(),
            setShort: jQuery(this).find("#inputSetShort").is(":checked"),
            short: jQuery(this).find("#inputShort").val(),
        }
    )
        .always(function () {
            jQuery("#answer div").hide();
        })
        .done(function (data) {
            let answer = JSON.parse(data);
            if (answer.type === "error") {
                jQuery("#answer div.alert-danger").html(answer.text).show();
            } else {
                jQuery("#answer div.alert-success").html(answer.text).show();
            }
        })
        .fail(function () {
            jQuery("#answer div.alert-danger").html("Unknown network error").show();
        });
});