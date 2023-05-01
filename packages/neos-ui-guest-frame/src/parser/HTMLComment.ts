/**
 * @neos-project/neos-ui-guest-frame - Guest frame initialization bindings
 *   Copyright (C) 2023 Contributors of Neos CMS
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

import { ContentElementEndMarker } from "./ContentElementEndMarker";
import { ContentElementStartMarker } from "./ContentElementStartMarker";
import { EditablePropertyMarker } from "./EditablePropertyMarker";
import { InsertionAnchorMarker } from "./InsertionAnchorMarker";

const CONTENT_ELEMENT_END_MARKER_PREFIX = "end:neos-ui-content-element:";
const CONTENT_ELEMENT_START_MARKER_PREFIX = "start:neos-ui-content-element:";
const EDITABLE_PROPERTY_MARKER_PREFIX = "neos-ui-editable:";
const INSERTION_ANCHOR_MARKER_PREFIX = "neos-ui-insertion-anchor:";

export class HTMLComment {
    public constructor(private readonly node: Node) {
        if (node.nodeType !== Node.COMMENT_NODE) {
            console.error("Node is not a comment node.", { node });
            throw new Error("Node is not a comment node.");
        }
    }

    public static *allWithin(element: HTMLElement) {
        const iterator = document.createNodeIterator(
            element,
            NodeFilter.SHOW_COMMENT,
            null
        );

        let node: null | Node;
        while ((node = iterator.nextNode())) {
            if (node.nodeType === Node.COMMENT_NODE) {
                yield new HTMLComment(node);
            }
        }
    }

    public toContentElementStartMarker(): null | ContentElementStartMarker {
        if (
            this.node.nodeValue!.startsWith(CONTENT_ELEMENT_START_MARKER_PREFIX)
        ) {
            const identifier = this.node.nodeValue!.slice(
                CONTENT_ELEMENT_START_MARKER_PREFIX.length
            );

            return new ContentElementStartMarker({
                node: this.node,
                identifier,
            });
        }

        return null;
    }

    public toContentElementEndMarker(): null | ContentElementEndMarker {
        if (
            this.node.nodeValue!.startsWith(CONTENT_ELEMENT_END_MARKER_PREFIX)
        ) {
            const identifier = this.node.nodeValue!.slice(
                CONTENT_ELEMENT_END_MARKER_PREFIX.length
            );

            return new ContentElementEndMarker({
                node: this.node,
                identifier,
            });
        }

        return null;
    }

    public toEditablePropertyMarker(): null | EditablePropertyMarker {
        if (this.node.nodeValue!.startsWith(EDITABLE_PROPERTY_MARKER_PREFIX)) {
            const [identifier, propertyName] = this.node
                .nodeValue!.slice(EDITABLE_PROPERTY_MARKER_PREFIX.length)
                .split("#");

            return new EditablePropertyMarker({ identifier, propertyName });
        }

        return null;
    }

    public toInsertionAnchorMarker(): null | InsertionAnchorMarker {
        if (this.node.nodeValue!.startsWith(INSERTION_ANCHOR_MARKER_PREFIX)) {
            const identifier = this.node.nodeValue!.slice(
                INSERTION_ANCHOR_MARKER_PREFIX.length
            );

            return new InsertionAnchorMarker({ identifier, node: this.node });
        }

        return null;
    }
}
