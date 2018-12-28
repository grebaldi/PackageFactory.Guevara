import {$get} from 'plow-js';
import {createSelector} from 'reselect';

export const contextPropertiesSelector = createSelector(
    [
        $get('cr.contentDimensions.allowedPresets'),
        $get('cr.contentDimensions.active'),
        $get('cr.workspaces.personalWorkspace.name')
    ],
    (dimensions, targetDimensions, workspaceName) => ({
        dimensions: Object.keys(dimensions.toJS()).map(key => ({
            key,
            values: dimensions[key]
        })),
        targetDimensions: Object.keys(targetDimensions.toJS()).map(key => ({
            key,
            value: targetDimensions[key][0]
        })),
        workspaceName
    })
);
