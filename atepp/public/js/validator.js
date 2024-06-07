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

function checkKeyValueInJson(jsonString, key, dataType) {
    try {
        const jsonObj = JSON.parse(jsonString)

        function checkDataType(value, dataType) {
            switch (dataType) {
                case 'string':
                    return typeof value === 'string'
                case 'number':
                    return typeof value === 'number'
                case 'boolean':
                    return typeof value === 'boolean'
                case 'null':
                    return value === null
                case 'object':
                    return typeof value === 'object' && value !== null && !Array.isArray(value)
                case 'array':
                    return Array.isArray(value)
                case 'any':
                    return value != null
                default:
                    return false
            }
        }

        function checkKey(obj, key, dataType) {
            if (obj.hasOwnProperty(key)) {
                return checkDataType(obj[key], dataType)
            }
            if (Array.isArray(obj)) {
                for (const item of obj) {
                    if (checkKey(item, key, dataType)) {
                        return true
                    }
                }
            } else if (typeof obj === 'object' && obj !== null) {
                for (const prop in obj) {
                    if (obj.hasOwnProperty(prop)) {
                        if (checkKey(obj[prop], key, dataType)) {
                            return true
                        }
                    }
                }
            }
            return false
        }

        return checkKey(jsonObj, key, dataType)
    } catch (error) {
        console.error('Invalid JSON string:', error)
        return false
    }
}

function checkKeyMustContainValueInJson(jsonString, key, values) {
    try {
        const data = JSON.parse(jsonString)
        const result = data.data.every(item => {
            if (typeof item !== 'object' || item[key] === undefined) {
                return false
            }
            const itemValue = item[key]
            return values.some(value => itemValue.includes(value))
        })
        return result
    } catch (error) {
        console.error("Error processing JSON:", error)
        return false
    }
}