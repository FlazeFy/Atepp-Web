function get_date_to_context(datetime, type){
    if(datetime){
        const result = new Date(datetime)

        if (type == "full") {
            const now = new Date(Date.now())
            const yesterday = new Date()
            const tomorrow = new Date()
            yesterday.setDate(yesterday.getDate() - 1)
            tomorrow.setDate(tomorrow.getDate() + 1)
            
            if (result.toDateString() === now.toDateString()) {
                return ` ${messages('today_at')} ${("0" + result.getHours()).slice(-2)}:${("0" + result.getMinutes()).slice(-2)}`
            } else if (result.toDateString() === yesterday.toDateString()) {
                return ` ${messages('yesterday_at')} ${("0" + result.getHours()).slice(-2)}:${("0" + result.getMinutes()).slice(-2)}`
            } else if (result.toDateString() === tomorrow.toDateString()) {
                return ` ${messages('tommorow_at')} ${("0" + result.getHours()).slice(-2)}:${("0" + result.getMinutes()).slice(-2)}`
            } else {
                return ` ${result.getFullYear()}/${(result.getMonth() + 1)}/${("0" + result.getDate()).slice(-2)} ${("0" + result.getHours()).slice(-2)}:${("0" + result.getMinutes()).slice(-2)}`
            }
        } else if (type == "24h" || type == "12h") {
            return `${("0" + result.getHours()).slice(-2)}:${("0" + result.getMinutes()).slice(-2)}`
        } else if (type == "datetime") {
            return ` ${result.getFullYear()}/${(result.getMonth() + 1)}/${("0" + result.getDate()).slice(-2)} ${("0" + result.getHours()).slice(-2)}:${("0" + result.getMinutes()).slice(-2)}`
        } else if (type == "date") {
            return `${result.getFullYear()}-${("0" + (result.getMonth() + 1)).slice(-2)}-${("0" + result.getDate()).slice(-2)}`
        } else if (type == "calendar") {
            const result = new Date(datetime)
            const offsetHours = get_UTC_hour_offset()
            result.setUTCHours(result.getUTCHours() + offsetHours)
        
            return `${result.getFullYear()}-${("0" + (result.getMonth() + 1)).slice(-2)}-${("0" + result.getDate()).slice(-2)} ${("0" + result.getHours()).slice(-2)}:${("0" + result.getMinutes()).slice(-2)}:00`
        }        
    } else {
        return "-"
    }
}

function get_UTC_hour_offset() {
    const offsetMi = new Date().getTimezoneOffset()
    const offsetHr = -offsetMi / 60
    return offsetHr
}