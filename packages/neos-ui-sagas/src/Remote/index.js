import {fetchWithErrorHandling} from '@neos-project/neos-ui-backend-connector';

export default function * withClient(client, script) {
    const query = function * query(queryString, variables) {
        const result = yield client.query({
            context: {
                headers: {
                    'X-Flow-Csrftoken': fetchWithErrorHandling._csrfToken
                }
            },
            query: queryString,
            variables
        });

        //
        // @TODO: process result
        //

        return result;
    };

    try {
        const result = yield * script({query});

        return result;
    } catch (error) {
        console.error(error);
        throw new Error(error.message);
    }
}
