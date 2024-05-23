function checkKeyInJson(jsonString, key) {
    try {
        const jsonObj = JSON.parse(jsonString);
        
        function checkKey(obj, key) {
            if (obj.hasOwnProperty(key)) {
                return true
            }
            if (Array.isArray(obj)) {
                for (const item of obj) {
                    if (checkKey(item, key)) {
                        return true
                    }
                }
            } else if (typeof obj === 'object' && obj !== null) {
                for (const prop in obj) {
                    if (obj.hasOwnProperty(prop)) {
                        if (checkKey(obj[prop], key)) {
                            return true
                        }
                    }
                }
            }
            return false
        }

        return checkKey(jsonObj, key)
    } catch (error) {
        console.error('Invalid JSON string:', error)
        return false
    }
}