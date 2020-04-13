export function prepareRequestHeaders() {
    return {
        'Accept': 'text/html, application/xhtml+xml',
        'Turbolinks-Referrer': `${window.location.href}`,
        'Content-Type': 'application/x-www-form-urlencoded'
    };
}

export async function handleResponse(response) {
    let responseHtml = await response.text();
    let location = response.headers.get('Turbolinks-Location');
    let snapshot = Turbolinks.Snapshot.wrap(responseHtml);

    if (!location) {
        location = window.location.href;
    }

    Turbolinks.controller.cache.put(location, snapshot);
    Turbolinks.visit(location, {action: 'restore'});

    return;
}

export async function submitForm(action, body, method = 'POST') {
    Turbolinks.controller.adapter.showProgressBarAfterDelay();

    try {
        let response = await fetch(action, {
            headers: prepareRequestHeaders(),
            method,
            body,
        });

        await handleResponse(response);
    } catch (error) {
        console.log(error);
    } finally {
        Turbolinks.controller.adapter.hideProgressBar();
    }

    return;
}