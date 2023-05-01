import { getGuestFrameDocument, getGuestFrameWindow } from "./dom";
import { Inventory } from "./parser/Inventory";

import styles from "./style.css";

const makeInitializeGuestFrame = (deps: {}) => {
    function* initializeGuestFrame() {
        const guestFrameWindow = getGuestFrameWindow();
        const guestFrameDocument = getGuestFrameDocument();

        if (guestFrameWindow && guestFrameDocument) {
            console.log("yay, initializing the guest frame", {
                guestFrameDocument,
                deps,
            });

            try {
                const inventory = Inventory.fromHTMLElement(
                    guestFrameDocument.body
                );

                guestFrameDocument.body.addEventListener(
                    "mouseup",
                    (ev) => {
                        if (
                            ev.target instanceof
                            (guestFrameWindow as any).HTMLElement
                        ) {
                            inventory.handleFocusRequest(
                                ev.target as HTMLElement
                            );
                            draw();
                        }
                    },
                    { capture: true }
                );

                const focusMarker = guestFrameDocument.createElement("div");
                focusMarker.classList.add(styles.focusMarker);

                guestFrameDocument.body.insertBefore(focusMarker, null);

                let focusRect: {
                    top: number;
                    left: number;
                    bottom: number;
                    right: number;
                } | null;
                const draw = () => {
                    if ((focusRect = inventory.focusRect)) {
                        focusMarker.style.transform = `translate(${focusRect.left - 5}px, ${focusRect.top - 5}px)`;
                        focusMarker.style.width = `${
                            focusRect.right - focusRect.left + 10
                        }px`;
                        focusMarker.style.height = `${
                            focusRect.bottom - focusRect.top + 10
                        }px`;
                        focusMarker.style.outlineColor = "blue";
                        focusMarker.style.opacity = "1";
                    } else {
                        focusMarker.style.opacity = "0";
                    }
                    requestAnimationFrame(draw);
                };

                draw();
            } catch (error) {
                console.error("Error during guest frame initialization", {
                    error,
                });
            }
        }
    }

    return initializeGuestFrame;
};

export default makeInitializeGuestFrame;
