export function serializeFieldValue(field, value) {
    if(value == null) {
        value = "";
    }

    if(typeof value === 'boolean') {
        value = +value;
    }

    return `${encodeURIComponent(field)}=${encodeURIComponent(value)}`;
}

export function serializeFormData(formData) {
    let data = formData;
    let serialized = [];
    
    for(let field in data) {
        let value = data[field];

        if(typeof value === 'object') {
            for(let locale in value) {
                let val = value[locale],
                localefield = `${locale}[${field}]`;

                serialized.push(serializeFieldValue(localefield, val));
            }
        } else {
            serialized.push(serializeFieldValue(field, value));
        }
    }

    return serialized.join('&');
}