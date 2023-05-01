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

import { html } from "./__test_utils__";

import { HTMLComment } from "./HTMLComment";
import { InsertionAnchorMarker } from "./InsertionAnchorMarker";
import { EditablePropertyMarker } from "./EditablePropertyMarker";
import { ContentElementEndMarker } from "./ContentElementEndMarker";
import { ContentElementStartMarker } from "./ContentElementStartMarker";

describe("HTMLComment", () => {
    it("can be created from a comment node with some content", () => {
        const { firstChild: commentNode } = html`<!-- Some Content -->`;

        expect(() => new HTMLComment(commentNode!)).not.toThrow();
    });

    it("cannot be created from a text node", () => {
        const { firstChild: commentNode } = html`Some Text`;

        jest.spyOn(console, "error").mockImplementation(() => {});

        expect(() => new HTMLComment(commentNode!)).toThrow();
    });

    it("cannot be created from an element node", () => {
        const { firstChild: commentNode } = html`<div>Some Content</div>`;

        jest.spyOn(console, "error").mockImplementation(() => {});

        expect(() => new HTMLComment(commentNode!)).toThrow();
    });

    describe("#toContentElementStartMarker", () => {
        it("returns null if the comment is empty", () => {
            const { firstChild: commentNode } = html`<!---->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementStartMarker()).toBe(null);
        });

        it("returns null if the comment is not a marker comment", () => {
            const { firstChild: commentNode } = html`<!--Hello World!-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementStartMarker()).toBe(null);
        });

        it("returns null if the comment is an end marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--end:neos-ui-content-element:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementStartMarker()).toBe(null);
        });

        it("returns null if the comment is an editable property marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--neos-ui-editable:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private#text-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementStartMarker()).toBe(null);
        });

        it("returns null if the comment is an insertion anchor marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--neos-ui-insertion-anchor:/sites/vendor-site/main@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementStartMarker()).toBe(null);
        });

        it("creates a ContentElementStartMarker if the comment is formatted respectively", () => {
            const {
                firstChild: commentNode,
            } = html`<!--start:neos-ui-content-element:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);
            const contentElementStartMarker =
                htmlComment.toContentElementStartMarker();

            expect(contentElementStartMarker).toEqual(
                new ContentElementStartMarker({
                    node: commentNode!,
                    identifier:
                        "/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private",
                })
            );
        });
    });

    describe("#toContentElementEndMarker", () => {
        it("returns null if the comment is empty", () => {
            const { firstChild: commentNode } = html`<!---->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementEndMarker()).toBe(null);
        });

        it("returns null if the comment is not a marker comment", () => {
            const { firstChild: commentNode } = html`<!--Hello World!-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementEndMarker()).toBe(null);
        });

        it("returns null if the comment is a start marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--start:neos-ui-content-element:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementEndMarker()).toBe(null);
        });

        it("returns null if the comment is an editable property marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--neos-ui-editable:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private#text-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementEndMarker()).toBe(null);
        });

        it("returns null if the comment is an insertion anchor marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--neos-ui-insertion-anchor:/sites/vendor-site/main@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toContentElementEndMarker()).toBe(null);
        });

        it("creates a ContentElementEndMarker if the comment is formatted respectively", () => {
            const {
                firstChild: commentNode,
            } = html`<!--end:neos-ui-content-element:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);
            const contentElementEndMarker =
                htmlComment.toContentElementEndMarker();

            expect(contentElementEndMarker).toEqual(
                new ContentElementEndMarker({
                    node: commentNode!,
                    identifier:
                        "/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private",
                })
            );
        });
    });

    describe("#toEditablePropertyMarker", () => {
        it("returns null if the comment is empty", () => {
            const { firstChild: commentNode } = html`<!---->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toEditablePropertyMarker()).toBe(null);
        });

        it("returns null if the comment is not a marker comment", () => {
            const { firstChild: commentNode } = html`<!--Hello World!-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toEditablePropertyMarker()).toBe(null);
        });

        it("returns null if the comment is a start marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--start:neos-ui-content-element:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toEditablePropertyMarker()).toBe(null);
        });

        it("returns null if the comment is an end marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--end:neos-ui-content-element:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toEditablePropertyMarker()).toBe(null);
        });

        it("returns null if the comment is an insertion anchor marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--neos-ui-insertion-anchor:/sites/vendor-site/main@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toEditablePropertyMarker()).toBe(null);
        });

        it("creates a EditablePropertyMarker if the comment is formatted respectively", () => {
            const {
                firstChild: commentNode,
            } = html`<!--neos-ui-editable:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private#text-->`;
            const htmlComment = new HTMLComment(commentNode!);
            const editablePropertyMarker =
                htmlComment.toEditablePropertyMarker();

            expect(editablePropertyMarker).toEqual(
                new EditablePropertyMarker({
                    identifier:
                        "/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private",
                    propertyName: "text",
                })
            );
        });
    });

    describe("#toInsertionAnchorMarker", () => {
        it("returns null if the comment is empty", () => {
            const { firstChild: commentNode } = html`<!---->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toInsertionAnchorMarker()).toBe(null);
        });

        it("returns null if the comment is not a marker comment", () => {
            const { firstChild: commentNode } = html`<!--Hello World!-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toInsertionAnchorMarker()).toBe(null);
        });

        it("returns null if the comment is a start marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--start:neos-ui-content-element:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toInsertionAnchorMarker()).toBe(null);
        });

        it("returns null if the comment is an end marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--end:neos-ui-content-element:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toInsertionAnchorMarker()).toBe(null);
        });

        it("returns null if the comment is an editable property marker comment", () => {
            const {
                firstChild: commentNode,
            } = html`<!--neos-ui-editable:/sites/vendor-site/main/node-citf96gxt64bh@user-admin;language=en_US&targetGroup=private#text-->`;
            const htmlComment = new HTMLComment(commentNode!);

            expect(htmlComment.toInsertionAnchorMarker()).toBe(null);
        });

        it("creates a InsertionAnchorMarker if the comment is formatted respectively", () => {
            const {
                firstChild: commentNode,
            } = html`<!--neos-ui-insertion-anchor:/sites/vendor-site/main@user-admin;language=en_US&targetGroup=private-->`;
            const htmlComment = new HTMLComment(commentNode!);
            const insertionAnchorMarker = htmlComment.toInsertionAnchorMarker();

            expect(insertionAnchorMarker).toEqual(
                new InsertionAnchorMarker({
                    identifier:
                        "/sites/vendor-site/main@user-admin;language=en_US&targetGroup=private",
                })
            );
        });
    });
});
