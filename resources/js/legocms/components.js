import Icon from "./common/Icon";
import AppShell from "./AppShell";
import Listings from "./Listings";
import Panel from "./Panel";
import ListingsHeader from "./Listings/Header";
import ListingsRow from "./Listings/Row";

let components = new Map([
    ['icon', Icon],
    ['legocms-shell', AppShell],
    ['legocms-panel', Panel],
    ['legocms-listings', Listings],
    ['legocms-listings-header', ListingsHeader],
    ['legocms-listings-row', ListingsRow],
]);

LegoCMS.register(components);