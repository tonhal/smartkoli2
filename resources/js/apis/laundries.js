const getLaundries = () => axios.get("/laundries");

const postLaundry = data => axios.post("/laundries", { ...data });

const deleteLaundry = id => axios.delete(`/laundries/${id}`);

export { getLaundries, postLaundry, deleteLaundry };
