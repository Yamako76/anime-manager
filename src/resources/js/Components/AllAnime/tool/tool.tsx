import { useWindowDimensions } from "@/Components/common/tool";

// ItemListを表示するBoxWidthを決定する関数 //
// minWidthを300, maxWidthを1200とし
// それ以外はwindow widthの7割とする
export const getBoxWidth = () => {
    const { width, _ } = useWindowDimensions();
    const BoxWidth = width * 0.7;
    if (BoxWidth > 1200) {
        return 1200;
    } else if (BoxWidth < 300) {
        return 300;
    } else {
        return BoxWidth;
    }
};

// ItemListを表示するBody画面の高さ //
export const getBodyHeight = () => {
    const { _, height } = useWindowDimensions();
    return height - 190;
};

// SearchBarWidthを決定する関数 //
// minWidthを280, maxWidthを1100とし
// それ以外はBoxWidth-100とする
export const getSearchBarWidth = () => {
    const SearchBarWidth = getBoxWidth() - 100;
    if (SearchBarWidth > 1100) {
        return 1100;
    } else if (SearchBarWidth < 280) {
        return 280;
    } else {
        return SearchBarWidth;
    }
};
