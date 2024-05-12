function form_count_char_limit(target_input_id, target_msg_id, max) {
    $( document ).ready(function() {
        $(`#${target_input_id}`).on("input", function() {
            let inputValue = $(this).val()
            let charCount = inputValue.length
            
            $(`#${target_msg_id}`).text(`${charCount}/${max}`)

            if(charCount >= max){
                $(`#${target_input_id}`).css({
                    "border": "1.5px solid var(--primaryColor)"
                });
                $(`#${target_msg_id}`).css({
                    "color": "var(--primaryColor)",
                });
            } else {
                $(`#${target_input_id}`).css({
                    "border": "1.5px solid white"
                });
                $(`#${target_msg_id}`).css({
                    "color": "var(--whiteColor)",
                });
            }
        });
    });
}