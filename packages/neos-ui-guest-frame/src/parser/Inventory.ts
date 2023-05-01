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
import { ContentElementRepository } from "./ContentElementRepository";
import { ContentElementStartMarker } from "./ContentElementStartMarker";
import { EditableProperty } from "./EditableProperty";
import { HTMLComment } from "./HTMLComment";
import { InsertionAnchor } from "./InsertionAnchor";

export class Inventory {
    private readonly contentElementRepository = new ContentElementRepository();

    private focusedContentElement: null | ContentElement = null;

    public static fromHTMLElement(element: HTMLElement): Inventory {
        const contentElementStartMarkers: ContentElementStartMarker[] = [];
        const result = new Inventory();

        for (const htmlComment of HTMLComment.allWithin(element)) {
            const contentElementStartMarker =
                htmlComment.toContentElementStartMarker();
            if (contentElementStartMarker) {
                contentElementStartMarkers.push(contentElementStartMarker);
                continue;
            }

            const contentElementEndMarker =
                htmlComment.toContentElementEndMarker();
            if (contentElementEndMarker) {
                const correspondingStartMarker =
                    contentElementStartMarkers.pop();
                if (!correspondingStartMarker) {
                    throw new Error(
                        "@TODO: End marker without corresponding start marker!"
                    );
                }
                const contentElement = contentElementEndMarker.toContentElement(
                    correspondingStartMarker
                );
                result.addContentElement(contentElement);
                continue;
            }

            const editablePropertyMarker =
                htmlComment.toEditablePropertyMarker();
            if (editablePropertyMarker) {
                result.addEditableProperty(
                    editablePropertyMarker.toEditableProperty()
                );
            }

            const insertionAnchorMarker = htmlComment.toInsertionAnchorMarker();
            if (insertionAnchorMarker) {
                result.addInsertionAnchor(
                    insertionAnchorMarker.toInsertionAnchor()
                );
            }
        }

        return result;
    }

    public addContentElement(contentElement: ContentElement): void {
        this.contentElementRepository.add(contentElement);
    }

    public addEditableProperty(editableProperty: EditableProperty): void {
        console.log("Editable Property was added", editableProperty);
    }

    public addInsertionAnchor(insertionAnchor: InsertionAnchor): void {
        console.log("Insertion Anchor was added", insertionAnchor);
    }

    public handleFocusRequest(element: HTMLElement): void {
        this.focusedContentElement =
            this.contentElementRepository.findOneByHTMLElement(element);
    }

    public get focusRect(): {
        top: number;
        left: number;
        bottom: number;
        right: number;
    } | null {
        if (this.focusedContentElement) {
            let focusRect = {
                top: Infinity,
                left: Infinity,
                bottom: 0,
                right: 0,
            };

            for (const el of this.focusedContentElement.containedElementNodes) {
                const { top, left, bottom, right } = el.getBoundingClientRect();
                focusRect.top = Math.min(top, focusRect.top);
                focusRect.left = Math.min(left, focusRect.left);
                focusRect.bottom = Math.max(bottom, focusRect.bottom);
                focusRect.right = Math.max(right, focusRect.right);
            }

            return focusRect;
        }

        return null;
    }
}
