import {takeLatest, put, select} from 'redux-saga/effects';
import {$get} from 'plow-js';
import gql from 'graphql-tag';

import backend from '@neos-project/neos-ui-backend-connector';

import {actions, actionTypes, selectors} from '@neos-project/neos-ui-redux-store';

import withClient from '../../Remote';

export default function * watchReloadState({configuration, graphqlClient}) {
    yield takeLatest(actionTypes.CR.Nodes.RELOAD_STATE, function * reloadState(action) {
        const {q} = backend.get();
        const currentSiteNodeContextPath = yield select($get('cr.nodes.siteNode'));
        const clipboardNodeContextPath = yield select($get('cr.nodes.clipboard'));
        const toggledNodes = yield select($get('ui.pageTree.toggled'));
        const siteNodeContextPath = $get('payload.siteNodeContextPath', action) || currentSiteNodeContextPath;
        const documentNodeContextPath = yield $get('payload.documentNodeContextPath', action) || select($get('ui.contentCanvas.contextPath'));
        yield put(actions.UI.PageTree.setAsLoading(currentSiteNodeContextPath));

        const siteNode = yield select(selectors.CR.Nodes.siteNodeSelector);

        const contextProperties = yield select(selectors.CR.ContentContext.contextPropertiesSelector);
        const test = yield * withClient(graphqlClient, ({query}) => {
            return query(gql`
                query($startingPoint: String!, $contextProperties: ContentContextProperties!) {
                    contentContext(properties:$contextProperties) {
                        flatTree(
                            startingPoint: $startingPoint,
                            depth: 1,
                            nodeTypeFilter: "Neos.Neos:Document"
                        ) {
                            contextPath
                            depth
                            identifier
                            label
                            name
                            nodeType {name}
                            properties {
                                name
                                type
                                value
                            }
                        }
                    }
                }
            `, {
                startingPoint: siteNode.get('identifier'),
                contextProperties
            });
        });


        const nodes = yield q([siteNodeContextPath, documentNodeContextPath]).neosUiDefaultNodes(
            configuration.nodeTree.presets.default.baseNodeType,
            configuration.nodeTree.loadingDepth,
            toggledNodes.toJS(),
            clipboardNodeContextPath
        ).getForTree();
        console.log({test, nodes});
        const nodeMap = nodes.reduce((nodeMap, node) => {
            nodeMap[$get('contextPath', node)] = node;
            return nodeMap;
        }, {});
        yield put(actions.CR.Nodes.setState({
            siteNodeContextPath,
            documentNodeContextPath,
            nodes: nodeMap,
            merge: $get('payload.merge', action)
        }));
        yield put(actions.UI.PageTree.setAsLoaded(currentSiteNodeContextPath));
    });
}
