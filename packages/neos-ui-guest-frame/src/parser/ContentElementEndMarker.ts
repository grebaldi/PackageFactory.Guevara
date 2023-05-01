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

import { ContentElement } from "./ContentElement";
import { ContentElementStartMarker } from "./ContentElementStartMarker";

export class ContentElementEndMarker {
    public constructor(
        private readonly data: {
            readonly node: Node;
            readonly identifier: string;
        }
    ) {}

    public get identifier(): string {
        return this.data.identifier;
    }

    public toContentElement(
        startMarker: ContentElementStartMarker
    ): ContentElement {
        const containedElementNodes: HTMLElement[] = [];

        let node = this.data.node;
        while (node.previousSibling) {
            node = node.previousSibling;

            if (startMarker.matchesNode(node)) {
                break;
            }

            if (node.nodeType === Node.ELEMENT_NODE) {
                containedElementNodes.push(node as HTMLElement);
            }
        }

        containedElementNodes.reverse();

        return new ContentElement({
            identifier: this.data.identifier,
            containedElementNodes,
        });
    }

    public matchesNode(node: Node): boolean {
        return this.data.node === node;
    }
}
