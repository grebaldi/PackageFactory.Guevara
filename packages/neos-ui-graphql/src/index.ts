import ApolloClient, {InMemoryCache} from 'apollo-boost';

export function createClient(endpoint: string): ApolloClient<InMemoryCache> {
    return new ApolloClient({
        uri: endpoint
    });
}
