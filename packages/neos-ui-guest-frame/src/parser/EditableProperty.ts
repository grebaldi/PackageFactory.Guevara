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

export class EditableProperty {
    public get element(): HTMLElement {
        throw new Error("\"get element()\" is not implemented yet!");
    }

    public get editor(): string {
        throw new Error("\"get editor()\" is not implemented yet!");
    }

    public get editorOptions(): unknown {
        throw new Error("\"get editorOptions()\" is not implemented yet!");
    }
}
