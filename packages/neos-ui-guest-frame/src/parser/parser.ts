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

import { HTMLComment } from "./HTMLComment";

export function* parse(element: HTMLElement) {
    for (const htmlComment of HTMLComment.allWithin(element)) {
        const contentElementStartMarker =
            htmlComment.toContentElementStartMarker();
        if (contentElementStartMarker) {
            yield contentElementStartMarker;
            continue;
        }

        const contentElementEndMarker = htmlComment.toContentElementEndMarker();
        if (contentElementEndMarker) {
            yield contentElementEndMarker;
            continue;
        }

        const editablePropertyMarker = htmlComment.toEditablePropertyMarker();
        if (editablePropertyMarker) {
            yield editablePropertyMarker;
            continue;
        }

        const insertionAnchorMarker = htmlComment.toInsertionAnchorMarker();
        if (insertionAnchorMarker) {
            yield insertionAnchorMarker;
            continue;
        }
    }
}
