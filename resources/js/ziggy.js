const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"users.search":{"uri":"users\/search","methods":["POST"]},"users.index":{"uri":"users\/index","methods":["POST"]},"users.update":{"uri":"users\/update\/{id}","methods":["POST"],"parameters":["id"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
