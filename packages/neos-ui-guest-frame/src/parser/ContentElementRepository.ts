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

export class ContentElementRepository {
    private readonly contentElementsByHTMLElement: WeakMap<
        HTMLElement,
        null | ContentElement
    > = new WeakMap();

    public add(contentElement: ContentElement): void {
        for (const element of contentElement.containedElementNodes) {
            if (!this.contentElementsByHTMLElement.has(element)) {
                this.contentElementsByHTMLElement.set(element, contentElement);
            }
        }
    }

    public findOneByHTMLElement(element: HTMLElement): null | ContentElement {
        if (element.parentElement === null) {
            return null;
        }

        if (this.contentElementsByHTMLElement.has(element)) {
            return this.contentElementsByHTMLElement.get(element)!;
        }

        const contentElement = this.findOneByHTMLElement(element.parentElement);
        this.contentElementsByHTMLElement.set(element, contentElement);

        return contentElement;
    }
}
