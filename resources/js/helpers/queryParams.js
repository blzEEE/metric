/**
 * Функция возвращает объект, полученный из строки query-параметров GET запроса
 *
 * @return Object
 */
const getObjectFromQueryString = (queryString) => {
console.log('getObjectFromQueryString')
console.log('queryString', queryString)
    const params = new URLSearchParams(queryString)
console.log('params', params)
    const obj = {}
    for (const key of params.keys()) {
        if (params.getAll(key).length > 1) {
            obj[key] = params.getAll(key)
        } else {
            obj[key] = params.get(key)
        }
    }

    return obj
}

/**
 * Функция возвращает новый объект, полученный из объекта GET параметров роута со значениями из объекта newValues
 *
 * @return Object
 */
const setQueryParams = (queryObject, newValues) => {

    const obj = JSON.parse(JSON.stringify(queryObject))

    for (const key in newValues) {
        obj[key] = newValues[key]
    }

    return obj
}

export default {
    getObjectFromQueryString,
    setQueryParams
}
