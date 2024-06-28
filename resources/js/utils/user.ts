import { Pagination, User } from "@/types/users.interface";
import axios from "axios";

export default class UserUtils {
    /**
     *
     * @param value The search term (string | number)
     * @returns A promise that resolves to an AxiosResponse object containing the result
     */
    static async searchUser(value: string | number): Promise<User[]> {
        try {
            const response = await axios.post(route("users.search"), {
                value,
            });
            return response.data;
        } catch (error) {
            throw error;
        }
    }

    /**
     * Fetches a paginated list of users from the specified URL or default route.
     * @param url Optional. The URL to fetch data from. If not provided, defaults to the route "users.index".
     * @returns A promise that resolves to a Pagination object containing an array of User objects.
     * @throws Throws an error if the HTTP request fails or returns a non-200 status code.
     */
    static async index(url?: string): Promise<Pagination<User[]>> {
        try {
            const response = await axios.post(url || route("users.index"));
            return response.data;
        } catch (error) {
            throw error;
        }
    }

    /**
     * Update user information asynchronously.
     * @param info An object containing the user ID and updated email.
     * @returns A Promise resolving to the updated User object.
     * @throws Error if the update request fails or returns a non-200 status.
     */
    static async update(info: { id: number; email: string }): Promise<User> {
        try {
            const response = await axios.put(
                route("users.update", { id: info.id }),
                info
            );
            return response.data;
        } catch (error) {
            throw error;
        }
    }
    /**
     * Deletes a user from the server.
     *
     * @param {number} id - The ID of the user to delete.
     * @returns {Promise<void>} A promise that resolves when the user is deleted, or rejects with an error.
     *
     * @throws {Error} - Re-throws any errors encountered during the deletion process.
     */
    static async delete(id: number): Promise<void> {
        try {
            const response = await axios.delete(
                route("users.delete", { id: id })
            );
        } catch (error) {
            throw error;
        }
    }
}
