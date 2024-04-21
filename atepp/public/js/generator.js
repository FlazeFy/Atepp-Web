function generate_last_date(val) {
    let dates = val.map(datetime => new Date(datetime))
    let now = new Date(Math.max(...dates))
    let today = new Date()
    today.setHours(0, 0, 0, 0)
  
    let difference = today.getTime() - now.getTime()
    let diff = Math.ceil(difference / (1000 * 3600 * 24))
  
    let res = 'undefined'
    if (diff === 1) {
        res = "Yesterday"
    } else if (diff <= 7) {
        res = `${diff} days ago`
    } else {
        res = now.toLocaleDateString('en-US', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        })
    }
  
    return res
}