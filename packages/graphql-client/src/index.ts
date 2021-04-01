import { createClient } from "@urql/core";
import { Record, String, Static } from "runtypes";

const configurationSchema = Record({
    graphQL: Record({
        endpointPath: String
    })
});

let configuration: Static<typeof configurationSchema> | null = null;
try {
    const rawConfiguration = JSON.parse(document.currentScript?.dataset.configuration ?? '{}');
    console.log({rawConfiguration});
    configuration = configurationSchema.check(rawConfiguration);
} catch (err) {
    console.log(err);
}

const client = createClient({
    url: configuration?.graphQL.endpointPath ?? ''
});


export function query<V extends object>(graphQLQuery: any, variables: V) {
    return client.query(graphQLQuery, variables);
}

export function mutation<V extends object>(graphQLMutation: any, variables: V) {
    return client.mutation(graphQLMutation, variables);
}
