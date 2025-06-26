<script>
// ========== IndexedDB Helper ==========
const DB_NAME = 'MyAppDB';
const DB_VERSION = 1;
const STORE_NAMES = ['hero', 'category', 'brand'];

function openDb() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);
        request.onerror = () => reject('DB open error');
        request.onsuccess = () => resolve(request.result);
        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            for (let name of STORE_NAMES) {
                if (!db.objectStoreNames.contains(name)) {
                    db.createObjectStore(name, { keyPath: 'id' });
                }
            }
        };
    });
}

async function saveToDB(storeName, dataArray) {
    const db = await openDb();
    const tx = db.transaction(storeName, 'readwrite');
    const store = tx.objectStore(storeName);
    dataArray.forEach(item => store.put(item));
    await tx.complete;
}

async function getFromDB(storeName) {
    const db = await openDb();
    const tx = db.transaction(storeName, 'readonly');
    const store = tx.objectStore(storeName);
    return new Promise((resolve, reject) => {
        const req = store.getAll();
        req.onsuccess = () => resolve(req.result);
        req.onerror = () => reject('Read failed');
    });
}

async function clearDB(storeName) {
    const db = await openDb();
    const tx = db.transaction(storeName, 'readwrite');
    tx.objectStore(storeName).clear();
    await tx.complete;
}
</script>
